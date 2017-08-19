import 'rich/vendors/axios'
import Errors from 'rich/components/form/Errors'

class Form {
    /**
     * Create a new Form instance.
     *
     * @param {object} data
     */
    constructor(data) {
        this.originalData = data

        for (let field in data) {
            this[field] = data[field]
        }

        this.errors = new Errors()
    }

    /**
     * Fetch all relevant data for the form.
     */
    data() {
        let data = {}

        for (let property in this.originalData) {
            data[property] = this[property]
        }

        return data
    }

    /**
     * Reset the form fields.
     */
    reset() {
        for (let field in this.originalData) {
            this[field] = this.originalData[field]
        }

        this.errors.clear()
    }

    /**
     * Send a GET request to the given URL.
     *
     * @param {string} url
     */
    get(url) {
        return new Promise((resolve, reject) => {
            axios.get(url, { params: this.data() })
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    this.onFail(error.response.data)

                    reject(error.response.data)
                })
        })
    }

    /**
     * Send a POST request to the given URL.
     *
     * @param {string} url
     */
    post(url) {
        return this.submit('post', url)
    }

    /**
     * Send a PUT request to the given URL.
     *
     * @param {string} url
     */
    put(url) {
        return this.submit('put', url)
    }

    /**
     * Send a PATCH request to the given URL.
     *
     * @param {string} url
     */
    patch(url) {
        return this.submit('patch', url)
    }

    /**
     * Send a DELETE request to the given URL.
     *
     * @param {string} url
     */
    delete(url) {
        return this.submit('delete', url)
    }

    /**
     * Submit the form.
     *
     * @param {string} requestType
     * @param {string} url
     */
    submit(requestType, url) {
        return new Promise((resolve, reject) => {
            axios[requestType](url, this.data())
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    this.onFail(error.response.data)

                    reject(error.response.data)
                })
        })
    }

    /**
     * Handle a failed form submission.
     *
     * @param {object} errors
     */
    onFail(errors) {
        this.errors.record(errors)
    }
}

export default Form
