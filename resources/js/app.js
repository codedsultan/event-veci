/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
// import '../css/app.css'
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering Components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */
import { createRouter, createWebHistory } from 'vue-router';
// import VueProgressBar from 'vue3-progressbar';
import VueProgressBar from '@aacassandra/vue3-progressbar'
// import VModal from 'jenesius-vue-modal'
// import VModal from 'vue3-modal';
import swal from 'sweetalert2';
import moment from 'moment';
import { Form } from 'vform';
// import '@aacassandra/vue3-progressbar/dist/style.css'; // Import progress bar styles

// Import Components
import Dropdown from './Components/Dropdown.vue';
import EditProfile from './Components/EditProfile.vue';
import AvatarForm from './Components/AvatarForm.vue';
import Recaptcha from './Components/Recaptcha.vue';
import SearchForm from './Components/SearchForm.vue';
import Events from './Components/Events.vue';
import ReplyForm from './Components/Reply-Form.vue';
import Reply from './Components/Reply.vue';
import Subscribe from './Components/Subscribe.vue';
import TicketForm from './Components/TicketForm.vue';
import DiscussionReply from './Components/DiscussionReply.vue';
import ContactForm from './Components/ContactForm.vue';
import EventFollow from './Components/EventFollow.vue';
import EventOption from './Components/EventOption.vue';
import Notifications from './Components/Notifications.vue';
import Dashboard from './Components/Dashboard.vue';
import Users from './Components/Users.vue';
import Topics from './Components/Topics.vue';
import EventsManage from './Components/EventsManage.vue';
import TicketManage from './Components/TicketManage.vue';
import Error from './Components/Error.vue';
import ProfileDropdown from './Components/ProfileDropdown.vue';
import BellNotifications from './Components/BellNotifications.vue';


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

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });


// Register global Components
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
app.component('profile-dropdown', ProfileDropdown);
app.component('bell-notifications', BellNotifications);

// app.component('pagination', require('laravel-vue-pagination').default);

// Configure Vue Router
const routes = [
  { path: '/eventx-dashboard', component: Dashboard },
  { path: '/manage-users', component: Users },
  { path: '/manage-topics', component: Topics },
  { path: '/manage-events', component: EventsManage },
  { path: '/manage-tickets', component: TicketManage },
  { path: '/:catchAll(.*)', component: Error }
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
// app.use(VModal);

app.mount('#app');

// Create separate Vue instances for different elements if needed
// const navApp = createApp({}).use(router).mount('#nav');
// const showApp = createApp({}).use(router).mount('#show');
// const app = createApp({});

// import ExampleComponent from './Components/ExampleComponent.vue';
// app.component('example-component', ExampleComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue Components. It will recursively scan this directory for the Vue
 * Components and automatically register them with their "basename".
 *
 * Eg. ./Components/ExampleComponent.vue -> <example-component></example-component>
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
