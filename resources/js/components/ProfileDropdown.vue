<template>
    <!-- <div class="dropdown relative" @click="toggleDropdown"> -->
        <Menu as="div" class="bg-white relative">
              <MenuButton class="-m-1.5 flex items-center p-1.5">
                <span class="sr-only">Open user menu</span>
                <img class="h-8 w-8 rounded-full bg-gray-50" :src="avatar" alt="" />
                <span class="hidden lg:flex lg:items-center">
                  <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true"><slot name="trigger"></slot></span>
                  <ChevronDownIcon class="ml-2 h-5 w-5 text-gray-400" aria-hidden="true" />
                </span>
              </MenuButton>
              <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                <MenuItems class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                  <!-- <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                    <a :href="item.href" :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 text-sm leading-6 text-gray-900']">{{ item.name }}</a>
                  </MenuItem> -->
                  <slot name="items"></slot>
                </MenuItems>
              </transition>
            </Menu>

    <!-- </div> -->

  </template>
  <script setup>
  import { ref, watch, onMounted, onUnmounted } from 'vue';
  import {

  Menu,
  MenuButton,
  MenuItem,
  MenuItems,

} from '@headlessui/vue'

import { ChevronDownIcon } from '@heroicons/vue/20/solid'
  const props = defineProps({

    item: Object,
    user: {
      type: Object,
      required: true,
    },
  });
  const avatar = ref(props.user.profile);
  // Reactive state
  const isOpen = ref(false);
  const userNavigation = [
        { name: 'Your profile', href: '#' },
        { name: 'Sign out', href: '#' },
    ]
  // Method to toggle the dropdown menu
  const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
  };

  // Method to close the dropdown if clicked outside
  const closeIfClickedOutside = (event) => {
    if (!event.target.closest('.vue-dropdown')) {
      isOpen.value = false;
    }
  };

  // Watch for changes to `isOpen` to add or remove the event listener
  watch(isOpen, (newValue) => {
    if (newValue) {
      document.addEventListener('click', closeIfClickedOutside);
    } else {
      document.removeEventListener('click', closeIfClickedOutside);
    }
  });

  // Cleanup event listener on component unmount
  onUnmounted(() => {
    document.removeEventListener('click', closeIfClickedOutside);
  });
  </script>
