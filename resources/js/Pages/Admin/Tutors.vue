<template>
    <Head>
        <title>Tutors</title>
    </Head>
    <div class="container">
        <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
        <div class="row my-3">
            <h2 class="text-center mt-3 mb-3 fw-bold" style="font-size: 50px; color: var(--blue)">Admin Panel</h2>
        </div>
        <div class="blur" style="width: 22rem; height: 30rem; left: 0;"></div>
        <div class="row my-3">
            <div class="col-md-1"></div>
        <div class="col-md-10">
            <nav class="navbar nav bg-body-tertiary px-3 mb-3"> 
                <li class="nav-item">
                    <Link class="nav-link fs-6 text-body-secondary" :href="route('admin1')">Dodaj/Ukloni Admina <i class="bi bi-people-fill text-primary"></i></Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link fs-6 rounded"   style="color: white; background: var(--gradient)"  :href="route('admin2')">Tutori <i class="bi bi-blockquote-right text-secondary"></i></Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link fs-6 text-body-secondary" :href="route('admin3')">Studenti <i class="bi bi-chat-dots-fill text-primary"></i></Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link fs-6 text-body-secondary" :href="route('admin5')">Istorija <i class="bi bi-clock-history text-primary"></i></Link>
                </li>
            </nav>
        </div>
        <div class="col-md-1"></div>
        </div>
        <div class="row my-3">
                <Link class="" style="" :href="route('admin2')"><h3 style="color: var(--darkGrey)">-Tabela Tutora</h3></Link>
                <Link class="" style="text-decoration: none" :href="route('admin4')"><h3 style="color: var(--darkGrey)">-Novi Zahtjevi</h3></Link>
           
        </div>
        <div class="row my-3">

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
                            <th scope="col">Predmeti</th>
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
                            <td>
                                <span v-if="user.subjects.length">
                                    <span v-for="subject in user.subjects" :key="subject.id" class="badge bg-primary me-1">
                                    {{ subject.name }}
                                    </span>
                                </span>
                                <span v-else class="text-muted">
                                    No subjects assigned
                                </span>
                            </td>
                            <td>{{ user.email }}</td>
                            <td>{{ formatDate(user.created_at) }}</td>
                            <td>
                                <button @click="openDeleteModal(user)" class="btn btn-danger btn-sm">X</button>
                            </td>
                            
                        </tr>
                    </tbody>
                </table>
                <div>
                    <Link preserve-scroll v-for="link in users.links" :key="link.label" v-html="link.label" :href="link.url" :class="{'text-secondary' : !link.url, 'text-primary fw-bold' : link.active}" class="p-1 mx-1" style="text-decoration: none"></Link>
                    <p>Showing {{ users.from }} to {{ users.to }} of {{ users.total }} results.</p>
                </div> 
            </div>
            

</div>
    </div>
    <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>


    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Ukloni</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Selektuj opciju:</p>
                    <ul>
                        <li class="my-3">
                            <button @click="stopTutor(selectedUser)" class="btn btn-warning btn-sm text-white">Ukloni Tutora</button>
                        </li>
                        <li class="my-3" v-for="subject in selectedUser?.subjects || []" :key="subject.id">
                            <button @click="deleteSubject(selectedUser.id, subject.id)" class="btn btn-primary btn-sm">{{ subject.name }}</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>








</template>


<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';

const props = defineProps({
    users: Object,
    searchTerm: String,
});

const search = ref(props.searchTerm);
const selectedUser = ref(null);

watch(search, debounce((q) => router.get('/admin3', { search: q }, { preserveState: true, preserveScroll: true }), 500));

const formatDate = (date) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString('en-US', options);
};

const openDeleteModal = (user) => {
    selectedUser.value = user;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
};

const stopTutor = (user) => {
    router.put(route('stop_tutor', { id: user.id }), {
        onSuccess: () => {
            alert('Uspješno ste uklonili tutora!');
            // Close the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            modal.hide();
        },
    });
};

const deleteSubject = (userId, subjectId) => {
    router.put(route('delete_subject_from_tutor', { id: userId, subject_id: subjectId }), {
        onSuccess: () => {
            alert('Uspješno ste uklonili predmet od tutora!');
            // Close the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            modal.hide();
        },
    });
};
</script>