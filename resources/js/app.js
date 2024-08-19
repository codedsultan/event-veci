/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import '../css/app.css'
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */
import { createRouter, createWebHistory } from 'vue-router';
// import VueProgressBar from 'vue3-progressbar';
import VueProgressBar from '@aacassandra/vue3-progressbar'
import VModal from 'jenesius-vue-modal'
// import VModal from 'vue3-modal';
import swal from 'sweetalert2';
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';
// import '@aacassandra/vue3-progressbar/dist/style.css'; // Import progress bar styles

// Import components
import Dropdown from './components/Dropdown.vue';
import EditProfile from './components/EditProfile.vue';
import AvatarForm from './components/AvatarForm.vue';
import Recaptcha from './components/Recaptcha.vue';
import SearchForm from './components/SearchForm.vue';
import Events from './components/Events.vue';
import ReplyForm from './components/Reply-Form.vue';
import Reply from './components/Reply.vue';
import Subscribe from './components/Subscribe.vue';
import TicketForm from './components/TicketForm.vue';
import DiscussionReply from './components/DiscussionReply.vue';
import ContactForm from './components/ContactForm.vue';
import EventFollow from './components/EventFollow.vue';
import EventOption from './components/EventOption.vue';
import Notifications from './components/Notifications.vue';
import Dashboard from './components/Dashboard.vue';
import Users from './components/Users.vue';
import Topics from './components/Topics.vue';
import EventsManage from './components/EventsManage.vue';
import TicketManage from './components/TicketManage.vue';
import Error from './components/Error.vue';

// Set up global properties and filters
const app = createApp({
  data() {
    return {
      swal: swal,
      Form: Form
    };
  },
  methods: {
    formatDate(data) {
      return moment(data).format("MMM Do YYYY");
    },
    formatExactDate(data) {
      return moment(data).format("MMM Do YY, h:mm:ss a");
    },
    now() {
      return moment();
    }
  },
  filters: {
    timeDate: function(data) {
      return this.formatDate(data);
    },
    timeExactDate: function(data) {
      return this.formatExactDate(data);
    },
    now: function() {
      return this.now();
    }
  }
});

// Register global components
app.component('dropdown', Dropdown);
app.component('edit-profile', EditProfile);
app.component('avatar-form', AvatarForm);
app.component('recaptcha', Recaptcha);
app.component('searchform', SearchForm);
app.component('events', Events);
app.component('reply-form', ReplyForm);
app.component('reply', Reply);
app.component('subscribe', Subscribe);
app.component('ticket-form', TicketForm);
app.component('discussionreply', DiscussionReply);
app.component('contact-form', ContactForm);
app.component('event-follow', EventFollow);
app.component('event-option', EventOption);
app.component('notifications', Notifications);
app.component('pagination', require('laravel-vue-pagination').default);

// Configure Vue Router
const routes = [
  { path: '/eventx-dashboard', component: Dashboard },
  { path: '/manage-users', component: Users },
  { path: '/manage-topics', component: Topics },
  { path: '/manage-events', component: EventsManage },
  { path: '/manage-tickets', component: TicketManage },
  { path: '*', component: Error }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Configure Vue Progress Bar
const progressBarOptions = {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
};

// Use plugins and mount app
app.use(router);
app.use(VueProgressBar, progressBarOptions);
app.use(VModal);

app.mount('#app');

// Create separate Vue instances for different elements if needed
const navApp = createApp({}).use(router).mount('#nav');
const showApp = createApp({}).use(router).mount('#show');
// const app = createApp({});

// import ExampleComponent from './components/ExampleComponent.vue';
// app.component('example-component', ExampleComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

// app.mount('#app');
