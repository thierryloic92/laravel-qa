import policies from './policies';

export default {
    install(Vue, options) {
        Vue.prototype.authorize = function(policy, model) {
            // console.log(window.Auth.signedIn);
            // console.log('In authorize function');
            if (!window.Auth.signedIn) return false;

            if (typeof policy === 'string' && typeof model === 'object') {
                const user = window.Auth.user;
                // console.log(user);
                // console.log("Policy" + policies[policy](user, model));
                return policies[policy](user, model);
                // return policies.modify(user,model);
                // return policies['modify'](user,model);
                //authorize ('modify','answer);
            }
        }

        Vue.prototype.signedIn = window.Auth.signedIn;
    }
}