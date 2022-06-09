const lib = {
    req(req, store, router) {
        if (typeof req.data == 'undefined') {
            req.data = {data:{}};
        }
        if (store.state.pay_pass) {
            req.data.data.cabinet_pay_password = store.state.pay_pass;
            store.commit('PAY_PASS', false);
        }
        req.data.device_fingerprint = store.state.fingerprint;
        console.log(req.data);
        store.commit('LOADER', true);
    },

    
    res(res, store, router) {
        console.log(res);
        store.commit('LOADER', false);
        if (res.data.isLogged === true) {
            store.commit('IS_LOGGED', res.data.isLogged);
        } else if (res.data.isLogged === false) {
            store.commit('IS_LOGGED', res.data.isLogged);
            store.commit('USER_DATA', {});
            store.commit('MODAL', {
                action: false,
                type: false,
                content: false,});
            store.commit('DARK_WRAPPER', false);
        } else {
            router.push('/unexpected');
        }
        if (res.data.modal) {
            if (res.data.modal == 'repeat') {
                res.data.body.repeat_url = res.config.url;
            }
            store.commit('MODAL_ACTION', true);
            store.commit('MODAL_TYPE', res.data.modal);
            store.commit('MODAL_CONTENT', res.data.body);
        }
        if (res.data.error) {
            store.commit('ERROR', res.data.error);
            if (res.data.error.error_code != '4020') {
                alert(`ERROR: ${res.data.error.error_text}`);
            }
        }
    },

    err(err, store, router) {
        store.commit('LOADER', false);
        if (err.response) {
            alert(`CODE: ${err.response.status}\n ${err.response.statusText}`);
        } else {
            alert('Unexpcected Http Error');
        }
    },

    checkRegExp(str, reg) {
        let regexp = new RegExp(reg);
        return regexp.test(str);
    },

    alertE(store, body) {
        store.commit('MODAL_ACTION', true);
        store.commit('MODAL_TYPE', 'answer');
        store.commit('MODAL_CONTENT', body);
    },

    isInt(x) {
        var y = parseInt(x);
        if (isNaN(y))
            return false;
        return x == y && x.toString() == y.toString();
    },

    HardcodeCurrPrecision(curr, amount) {

        if (this.inArray(curr, ['RUR', 'USD', 'EUR', 'VLS']) != -1)
            return 2;
        else if (this.inArray(curr, ['BTC']) != -1)
            return 8;
        else if (this.inArray(curr, ['ETH']) != -1)
            return 10;
        else
            return amount.split('.').pop().length || 2;
    },

    inArray(curr, arr) {
        if (arr.indexOf("curr") != -1) {  
            return true;
        } else {
            return false;
        }
    }

}

export default lib;