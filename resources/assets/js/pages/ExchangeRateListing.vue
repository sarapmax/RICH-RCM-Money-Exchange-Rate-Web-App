<template>
    <div class="row">
        <notifications />
        <div class="last-updated col-md-12">
            <h4><i class="fa fa-refresh"> </i> Last updated: {{ currencyLastUpdated | formatDate }}</h4>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table" id="currency-exchange-rate-table">
                    <thead>
                        <tr>
                            <th>Currency</th>
                            <th></th>
                            <th><label class="label label-info large-label">Buying</label></th>
                            <th><label class="label label-danger large-label">Selling</label></th>
                        </tr>
                    </thead>
                    <tbody v-for="c in currency">
                        <tr @click="showUpdateCurrency(c.id)">
                            <th>
                                <ul class="currency-flag">
                                    <li><span :class="'flag-icon flag-icon-' + c.country.flag.toLowerCase()"></span></li>
                                    <li>
                                        {{ c.name }}
                                    </li>
                                </ul>
                                <small>{{ c.country.name }}</small>
                            </th>
                            <th>{{ c.unit }}</th>
                            <th class="text-info">Buying</th>
                            <th class="text-danger">Selling</th>
                        </tr>
                        <tr v-for="banknote in c.banknotes">
                            <td></td>
                            <td><b>{{ banknote.name }}</b></td>
                            <td class="buying-price"><b>{{ banknote.buying }}</b></td>
                            <td class="selling-price"><b>{{ banknote.selling }}</b></td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <hr>
                    <button v-if="!guest" @click="showAddCurrency" class="btn btn-primary btn-block bottom-buffer-lg"><i class="fa fa-plus"></i> Add Currency</button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="currencyModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Manage Currency</h4>
                    </div>
                    <form id="currency-form" @submit.prevent="manageCurrency">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form-group
                                            v-model="form.country_id"
                                            field-name="country"
                                            :error="form.errors.get('country_id')"
                                            text="Country"
                                            input-type="select"
                                            :options="countries"
                                    />
                                </div>
                                <div class="col-md-4">
                                    <form-group
                                            v-model="form.name"
                                            field-name="name"
                                            :error="form.errors.get('name')"
                                            text="Currency Name"
                                            input-type="text"
                                            placeholder="USD, THB, EUR"
                                    />
                                </div>
                                <div class="col-md-2">
                                    <form-group
                                            v-model="form.unit"
                                            field-name="unit"
                                            :error="form.errors.get('unit')"
                                            text="Currency Unit"
                                            input-type="text"
                                            placeholder="$, €"
                                    />
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" @click="addBanknote" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add banknotes</button>
                                </div>
                            </div>
                            <br/>
                            <div v-for="banknote, index in form.banknotes" class="row banknote-form">
                                <input type="hidden" v-model="banknote.id">
                                <div class="col-md-4">
                                    <form-group
                                            v-model="banknote.name"
                                            field-name="banknotes-name"
                                            :error="form.errors.get(`banknotes.${index}.name`)"
                                            text="Banknote"
                                            input-type="text"
                                    />
                                </div>
                                <div class="col-md-3">
                                    <form-group
                                            v-model="banknote.buying"
                                            field-name="banknotes-buying"
                                            :error="form.errors.get(`banknotes.${index}.buying`)"
                                            text="Buying"
                                            input-type="text"
                                    />
                                </div>
                                <div class="col-md-3">
                                    <form-group
                                            v-model="banknote.selling"
                                            field-name="banknotes-selling"
                                            :error="form.errors.get(`banknotes.${index}.selling`)"
                                            text="Selling"
                                            input-type="text"
                                    />
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label">Remove</label>
                                    <div>
                                        <button type="button" @click="removeBanknote(index, banknote.id)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button v-if="form.isUpdate" type="button" @click="deleteCurrency" class="btn btn-danger">Remove</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import 'rich/vendors/axios'
    import Form from 'rich/components/form/Form'
    import FormGroup from 'rich/components/form/FormGroup'
    import 'vue-notification'

    export default {
        props: {
            guest: {
                required: true
            }
        },

        data() {
            return {
                currency: {},
                currency_id: null,
                form: new Form({
                    name: '',
                    unit: '',
                    country_id: '',
                    banknotes: [],
                    isUpdate: false
                }),
                countries: [],
                currencyLastUpdated: ''
            }
        },

        components: {
            FormGroup
        },

        created() {
            this.getCurrencyWithBanknotes()
            this.getCurrencyLastUpdated()

            if(!this.guest) {
                this.getAllCountries()
            }

            Echo.channel('currencyChangingChannel')
                .listen('CurrencyEvent', (e) => {
                    this.getCurrencyWithBanknotes()
                    this.getCurrencyLastUpdated()
                })
        },

        methods: {
            showAddCurrency() {
                this.form.reset()

                this.form.isUpdate = false

                this.showCurrencyModal()
            },

            manageCurrency() {
                let postCurrencyUrl

                if(this.form.isUpdate) {
                    postCurrencyUrl = `admin/currency/${this.currency_id}/update`
                }else {
                    postCurrencyUrl = 'admin/currency/add'
                }

                this.form.post(postCurrencyUrl)
                    .then(data => {
                        $('#currencyModal').modal('hide')

                        this.$notify({
                            title: 'Success',
                            text: 'Currecy was updated successfully!',
                            type: 'success'
                        });

                        this.getCurrencyWithBanknotes()
                        this.getCurrencyLastUpdated()
                    })
                    .catch(error => {})
            },

            deleteCurrency() {
                if(confirm('Are you sure to delete this?')) {
                    this.form.post(`admin/currency/${this.currency_id}/delete`).then(data => {
                        $('#currencyModal').modal('hide')

                        this.$notify({
                            title: 'Success',
                            text: 'Currecy was deleted successfully!',
                            type: 'success'
                        });

                        this.getCurrencyWithBanknotes()
                    })
                }
            },

            getCurrencyWithBanknotes() {
                axios.get('currency')
                    .then(({ data }) => {
                        this.currency = data
                    })
            },

            showUpdateCurrency(currency_id) {
                this.currency_id = currency_id
                this.form.isUpdate = true
                this.form.errors.clear()

                axios.get(`admin/currency/${currency_id}`)
                    .then(({ data }) => {
                        this.form.country_id = data.country_id
                        this.form.name = data.name
                        this.form.unit = data.unit

                        this.form.banknotes = data.banknotes

                        this.showCurrencyModal()
                    })
            },

            addBanknote() {
                this.form.banknotes.push({
                    name: null,
                    buying: null,
                    selling: null
                })
            },

            removeBanknote(index, banknote_id) {
                if(this.form.isUpdate) {
                    if(confirm('Are you sure to delete this?')) {
                        axios.post(`admin/banknote/${banknote_id}/delete`).then(data => {
                            this.$notify({
                                title: 'Success',
                                text: 'Banknote was deleted successfully!',
                                type: 'success'
                            });

                            this.getCurrencyWithBanknotes()
                        })

                        this.form.banknotes.splice(index, 1);
                    }
                }else {
                    this.form.banknotes.splice(index, 1);
                }
            },

            showCurrencyModal() {
                $('#currencyModal').modal({
                    show: true,
                    backdrop: 'static'
                })
            },

            getAllCountries() {
                axios.get('admin/countries').then(({ data }) => {
                    this.countries = this.selectizeDbData(data)
                })
            },

            getCurrencyLastUpdated() {
                axios.get('currency-last-updated').then(({ data }) => {
                    this.currencyLastUpdated = data.updated_at
                })
            }
        }
    }
</script>
