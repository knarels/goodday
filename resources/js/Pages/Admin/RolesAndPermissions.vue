<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, watch, computed } from 'vue';
import { useForm} from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    users: Object,
    roles: Object,
    permissions: Object,
});

const page = usePage();
const currentTab = ref('users');
const showUserRolesModal = ref(false);
const selectedUser = ref(null);
const userRolesForm = useForm({
    roles: [],
});

const showRolePermissionsModal = ref(false);
const selectedRole = ref(null);
const rolePermissionsForm = useForm({
    permissions: [],
});

const openUserRoles = (user) => {
    selectedUser.value = user;
    userRolesForm.roles = user.roles.map(role => role.name);
    showUserRolesModal.value = true;
};

const updateUserRoles = () => {
    userRolesForm.put(route('admin.users.update-roles', selectedUser.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            showUserRolesModal.value = false;
            selectedUser.value = null;
            userRolesForm.reset();
        },
        onError: (errors) => {
            console.error('Error updating user roles:', errors);
        },
    });
};

const openRolePermissions = (role) => {
    selectedRole.value = role;
    rolePermissionsForm.permissions = role.permissions.map(permission => permission.name);
    showRolePermissionsModal.value = true;
};

const updateRolePermissions = () => {
    rolePermissionsForm.put(route('admin.roles.update-permissions', selectedRole.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            showRolePermissionsModal.value = false;
            selectedRole.value = null;
            rolePermissionsForm.reset();
        },
        onError: (errors) => {
            console.error('Error updating role permissions:', errors);
        },
    });
};

const showFlash = ref(false);
const flashMessage = computed(() => page.props.flash?.success || page.props.flash?.error);
const flashType = computed(() => page.props.flash?.success ? 'success' : 'error');

watch(flashMessage, (newValue) => {
    if (newValue) {
        showFlash.value = true;
        setTimeout(() => {
            showFlash.value = false;
            if (page.props.flash) {
                page.props.flash.success = null;
                page.props.flash.error = null;
            }
        }, 3000);
    }
}, { immediate: true });

</script>

<template>
    <Head title="Roles & Permissions" />

    <AppLayout title="Roles & Permissions">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles & Permissions Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                    <div v-if="showFlash"
                         :class="{
                             'bg-green-100 border border-green-400 text-green-700': flashType === 'success',
                             'bg-red-100 border border-red-400 text-red-700': flashType === 'error'
                         }"
                         role="alert"
                         class="px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">{{ flashType === 'success' ? 'Success!' : 'Error!' }}</strong>
                        <span class="block sm:inline ml-2">{{ flashMessage }}</span>
                        <span @click="showFlash = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                            <svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </span>
                    </div>

                    <div class="mb-6 border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <button @click="currentTab = 'users'"
                                    :class="[currentTab === 'users' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm rounded-t-lg focus:outline-none']">
                                Manage User Roles
                            </button>
                            <button @click="currentTab = 'roles'"
                                    :class="[currentTab === 'roles' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm rounded-t-lg focus:outline-none']">
                                Manage Role Permissions
                            </button>
                        </nav>
                    </div>

                    <div v-show="currentTab === 'users'">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Users</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="user in props.users.data" :key="user.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ user.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ user.email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span v-for="role in user.roles" :key="role.id" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 mr-1">
                                                {{ role.name }}
                                            </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button @click="openUserRoles(user)" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit Roles</button>
                                    </td>
                                </tr>
                                <tr v-if="props.users.data.length === 0">
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No users found.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div v-show="currentTab === 'roles'">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Roles</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="role in props.roles.data" :key="role.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ role.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span v-for="permission in role.permissions" :key="permission.id" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1">
                                                {{ permission.name }}
                                            </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button @click="openRolePermissions(role)" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit Permissions</button>
                                    </td>
                                </tr>
                                <tr v-if="props.roles.data.length === 0">
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">No roles found.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div v-if="showUserRolesModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
                        <div class="relative p-8 bg-white w-full max-w-md mx-auto rounded-lg shadow-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Roles for {{ selectedUser?.name }}</h3>
                            <form @submit.prevent="updateUserRoles">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Assign Roles:</label>
                                    <div class="space-y-2">
                                        <div v-for="role in props.roles.data" :key="role.id" class="flex items-center">
                                            <input type="checkbox" :id="`user-role-${role.id}`" :value="role.name" v-model="userRolesForm.roles" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                            <label :for="`user-role-${role.id}`" class="ml-2 text-sm text-gray-900">{{ role.name }}</label>
                                        </div>
                                    </div>
                                    <div v-if="userRolesForm.errors.roles" class="text-red-500 text-sm mt-1">{{ userRolesForm.errors.roles }}</div>
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button type="button" @click="showUserRolesModal = false" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Cancel
                                    </button>
                                    <button type="submit" :disabled="userRolesForm.processing" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                                        {{ userRolesForm.processing ? 'Saving...' : 'Save Roles' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div v-if="showRolePermissionsModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
                        <div class="relative p-8 bg-white w-full max-w-md mx-auto rounded-lg shadow-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Permissions for Role: {{ selectedRole?.name }}</h3>
                            <form @submit.prevent="updateRolePermissions">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Assign Permissions:</label>
                                    <div class="space-y-2">
                                        <div v-for="permission in props.permissions.data" :key="permission.id" class="flex items-center">
                                            <input type="checkbox" :id="`role-permission-${permission.id}`" :value="permission.name" v-model="rolePermissionsForm.permissions" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                            <label :for="`role-permission-${permission.id}`" class="ml-2 text-sm text-gray-900">{{ permission.name }}</label>
                                        </div>
                                    </div>
                                    <div v-if="rolePermissionsForm.errors.permissions" class="text-red-500 text-sm mt-1">{{ rolePermissionsForm.errors.permissions }}</div>
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button type="button" @click="showRolePermissionsModal = false" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Cancel
                                    </button>
                                    <button type="submit" :disabled="rolePermissionsForm.processing" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                        {{ rolePermissionsForm.processing ? 'Saving...' : 'Save Permissions' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
