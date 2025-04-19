<template>
    <Head>
        <title>Dashboard</title>
    </Head>
    <div class="container">
        <div class="row d-flex align-items-center my-3">
            <div class="col-md-3 d-flex justify-content-end">
                <div>
                    <Link :href="route('dashboard')" class="fs-5"><-Početna</Link>
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="text-center mt-3 mb-3 fw-bold" style="font-size: 50px; color: var(--blue)">Tutor Stranica</h2>
            </div>
            <div class="col-md-3">
                <h4>Broj održanih časova: {{ scheduleCount }}</h4>
                <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <h3>Predmeti koje podučavaš:</h3> 
                <span v-if="user.subjects.length">
                    <span v-for="subject in user.subjects" :key="subject.id" class="badge bg-primary me-1">
                    {{ subject.name }}
                    </span>
                </span>
                <span v-else class="text-muted">
                    Nema predmeta
                </span>
                <div class="my-3">
                    <Link :href="route('tutors.create1')" class="fs-6 my-4">Dodaj predmete</Link>
                    <div class="my-1">
                        <button class="btn btn-sm btn-outline-secondary" @click="openDeleteModal(user)">Ukloni predmete</button>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="blur" style="width: 22rem; height: 30rem; left: 0;"></div>
                <nav class="navbar nav bg-body-tertiary px-3 mb-3"> 
                    <li class="nav-item">
                        <Link class="nav-link fs-6 text-body-secondary" :href="route('tutor.dashboard')">Termini <i class="bi bi-newspaper text-primary"></i></Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link fs-6 rounded" style="color: white; background: var(--gradient)" :href="route('tutor.dashboard1')">Zahtjevi <i class="bi bi-envelope"></i></Link>
                    </li>
                    <li class="nav-item">
                        <Link  class="nav-link fs-6 text-body-secondary" :href="route('tutor.dashboard2')">Raspored <i class="bi bi-table text-primary"></i></Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link fs-6 text-body-secondary" :href="route('tutor.dashboard3')">Istorija <i class="bi bi-clock-history text-primary"></i></Link>
                    </li>
                </nav>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row my-3">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <h3>Zahtjevi</h3>

                <div v-if="requests.length === 0" class="alert alert-warning text-center">
                    Nema novih zahtjeva
                </div>

                <table v-else class="table table-secondary table-bordered table-striped table-hover my-3" style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    <thead>
                        <tr>
                            <th scope="col">Slika</th>
                            <th scope="col">Ime i Prezime</th>
                            <th scope="col">Razred</th>
                            <th scope="col">Predmet</th>
                            <th scope="col">Detalji</th>
                            <th scope="col">Datum</th>
                            <th scope="col">Čas</th>
                            <th scope="col">Prihvati</th>
                            <th scope="col">Odbij</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="request in requests" :key="request.id">

                            <td>
                                <img :src="getUserAvatar(request.user_id)" 
                                    alt="User Avatar" 
                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%">
                            </td>
                            <!-- Ime i Prezime -->
                            <td>{{ getUserFullName(request.user_id) }}</td>
                            
                            <!-- Razred -->
                            <td>{{ romanNum(getUserGrade(request.user_id)) }}</td>
                            
                            <!-- Predmet -->
                            <td>{{ getSubjectName(request.subject_id) }}</td>
                            
                            <!-- Detalji -->
                            <td>{{ request.details }}</td>
                            
                            <!-- Datum -->
                            <td>{{ formatDate(request.date) }}</td>
                            
                            <!-- Čas -->
                            <td>{{ request.hour_id }}.</td>
                            <td>
                                <button class="btn btn-sm btn-success" @click="acceptRequest(request)"><i class="bi bi-check-lg"></i></button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger" @click="declineRequest(request)">X</button>
                            </td>
                        </tr>
                    </tbody>
                </table>


            </div>
            <div class="col-md-1"></div>
        </div>
    </div>

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
                            <button @click="stopTutor(user)" class="btn btn-warning btn-sm text-white">Prestani biti tutor</button>
                        </li>
                        <li class="my-3" v-for="subject in user?.subjects || []" :key="subject.id">
                            <button @click="deleteSubject(user.id, subject.id)" class="btn btn-primary btn-sm">{{ subject.name }}</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    users: Array,
    requests: Array,
    scheduleCount: Number 
});

const form = useForm({
    user_id: null,
    tutor_id: null,
    date: null,
    hour_id: null,
});

const getUserAvatar = (userId) => {
    const user = props.users.find((u) => u.id === userId); 
    return user && user.avatar ? `../storage/${user.avatar}` : `../storage/avatars/default.jpg`;
};


const acceptRequest = (request) => {
    form.user_id = request.user_id;
    form.tutor_id = props.user.id;
    form.date = request.date;
    form.hour_id = request.hour_id;
    
    form.put(route('accept_request'), {
        preserveScroll: true,
        onSuccess: () => {
            alert('Zahtjev prihvaćen!');
        },
        onError: (errors) => {
            alert('Greska!');
        },
    });
};

const declineRequest = (request) => {
    form.user_id = request.user_id;
    form.tutor_id = props.user.id;
    form.date = request.date;
    form.hour_id = request.hour_id;
    
    form.delete(route('decline_request'), {
        preserveScroll: true,
        onSuccess: () => {
            alert('Zahtjev odbijen!');
        },
        onError: (errors) => {
            alert('Greska!');
        },
    });
};

const getUserFullName = (userId) => {
    const user1 = props.users.find((u) => u.id === userId);  // Search the users array, not requests
    return user1 ? `${user1.name} ${user1.last_name}` : 'Unknown';
};

// Function to get the user's grade
const getUserGrade = (userId) => {
    const user2 = props.users.find((u) => u.id === userId);  // Search the users array, not requests
    return user2 ? user2.grade : 'Unknown';
};

const getSubjectName = (subjectId) => {
    const subject = props.user.subjects.find((s) => s.id === subjectId);
    return subject ? subject.name : 'Unknown';
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Intl.DateTimeFormat('en-US', options).format(date);
};


function romanNum(num) {
    if(num===1){
        return 'I';
    }
    else if(num===2){
        return 'II';
    }
    else if(num===3){
        return 'III';
    }
    else{
        return 'IV';
    }
}


const openDeleteModal = (user) => {
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
};

const stopTutor = (user) => {
    console.log('pokrenuto');
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