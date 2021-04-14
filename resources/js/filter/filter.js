import moment from 'moment'
import Vue from 'vue';

Vue.filter('time', (value) => {
    return moment(value).format('MMM Do YYYY, h:mm:ss a');
});

Vue.filter('substring', (content, length) => {
    return content.substring(0, length);
});

Vue.filter('capitalize', (value) => {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
});

