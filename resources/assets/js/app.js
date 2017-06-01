window.Vue = require('vue');
window.axios = require('axios');
window.debounce = require('debounce');
import {
    DatePicker,
    TimeSelect,
    TimePicker
    } from 'element-ui';
import lang from 'element-ui/lib/locale/lang/en';
import locale from 'element-ui/lib/locale';
import 'element-ui/lib/theme-default/index.css';

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

$.ajaxSetup({
    beforeSend: function(xhr) {
        xhr.setRequestHeader('X-CSRF-TOKEN', window.Laravel.csrfToken);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    }
});

locale.use(lang)
Vue.use(DatePicker);
Vue.use(TimeSelect);
Vue.use(TimePicker);

Vue.component(
    'autocomplete',
    require('./components/autocompleteCard.vue')
);

Vue.component(
    'timeanddate',
    require('./components/timeanddate.vue')
);

Vue.component(
    'simpleform',
    require('./components/simpleform.vue')
);

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

new Vue({
    el: '#root',
    data() {
      return {

      };
    }
});
