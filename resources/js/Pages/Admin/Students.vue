<template>
    <Head>
        <title>Students</title>
    </Head>
    <div class="container">
        <div class="blur" style="width: 22rem; height: 30rem; left: 0;"></div>
        <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
        <div class="row my-3">
            <h2 class="text-center mt-3 mb-3 fw-bold" style="font-size: 50px; color: var(--blue)">Admin Panel</h2>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
        <div class="col-md-10">
            <nav class="navbar nav bg-body-tertiary px-3 mb-3"> 
                <li class="nav-item">
                    <Link class="nav-link fs-6 text-body-secondary" :href="route('admin1')">Dodaj/Ukloni Admina <i class="bi bi-people-fill text-primary"></i></Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link fs-6 text-body-secondary" :href="route('admin2')">Tutori <i class="bi bi-blockquote-right text-primary"></i></Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link fs-6 rounded" style="color: white; background: var(--gradient)" :href="route('admin3')">Studenti <i class="bi bi-chat-dots-fill text-secondary"></i></Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link fs-6 text-body-secondary" :href="route('admin5')">Istorija <i class="bi bi-clock-history text-primary"></i></Link>
                </li>
            </nav>
        </div>
        <div class="col-md-1"></div>
        </div>
        <div class="row my-3">
            <h3 style="color: var(--darkGrey)">Tabela Studenata</h3>

            <div>
                            <div class="d-flex justify-content-end mb-4">
                                <div style="width: 100%">
                                    <input preserve-scroll type="search" style="width: 100%" class="form-control" placeholder="Search" v-model="search">
                                </div>
                            </div>
                            <table class="table table-secondary table-bordered table-striped table-hover" style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                                <thead class="">
                                    <tr>
                                        <th scope="col">Slika</th>
                                        <th scope="col">Ime</th>
                                        <th scope="col">Prezime</th>
                                        <th scope="col">Razred</th>
                                        <th scope="col">Smjer</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Datum Registracije</th>
                                        <th scope="col">Obriši</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in users.data" :key="user.id">
                                        <td>
                                            <img :src="user.avatar ? ('storage/' + user.avatar)  : ('storage/avatars/default.jpg')" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%">
                                        </td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.last_name }}</td>
                                        <td>{{ user.grade }}</td>
                                        <td>{{ user.major.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ formatDate(user.created_at) }}</td>
                                        <td><button @click="deleteUser(user.id)" class="btn btn-danger btn-sm ">X</button></td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                            <div>
                                <Link preserve-scroll v-for="link in users.links" :key="link.label" v-html="link.label" :href="link.url" :class="{'text-secondary' : !link.url, 'text-primary fw-bold' : link.active}" class="p-1 mx-1" style="text-decoration: none"></Link>
                                <p>Showing {{ users.from }} to {{ users.to }} of {{ users.total }} results.</p>
                            </div> 
                        </div>
                        <div class="blur" style="width: 22rem; height: 30rem; right: 40rem;"></div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { debounce } from 'lodash';

    const props = defineProps({
        users: Object,
        searchTerm: String,
    });
    const search = ref(props.searchTerm);

    watch(search, debounce((q) => router.get('/admin2', {search:q}, { preserveState: true, preserveScroll: true }), 500));

    const formatDate = (date) => {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const formattedDate = new Date(date).toLocaleDateString('en-US', options);
        return formattedDate;
    };


    const deleteUser = (userId) => {
        if (confirm('Are you sure you want to delete this user?')) {
            router.delete(route('users.destroy', { id: userId }), {
                onSuccess: () => alert('User deleted successfully!'),
            });
        }
    };

   
</script>