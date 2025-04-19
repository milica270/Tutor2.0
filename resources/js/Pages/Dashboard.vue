<template>
    <Head>
        <title>Dashboard</title>
    </Head>
    <div class="container">
        <div class="row d-flex align-items-center my-3">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2 class="text-center mt-3 mb-3 fw-bold" style="font-size: 50px; color: var(--blue)">Početna</h2>
            </div>
            <div class="col-md-3">
                <div v-if="($page.props.auth.user.is_tutor) === 0">
                    <Link :href="route('tutors.create')" class="fs-5">Postani tutor-></Link>
                </div>
                <div v-else>
                    <Link :href="route('tutor.dashboard')" class="fs-5">Tutor Stranica-></Link>
                </div>
        
            </div>
            
        </div>
        <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
        <div class="row my-3">
            <div class="col-md-1"></div>
            <div class="col-md-8">
                    <div class="d-flex align-items-center gap-1">
                        <img class="card-img-top mx-2" :src="user.avatar ? ('storage/' + user.avatar)  : ('storage/avatars/default.jpg')" alt="" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%">
                        <div class="card-body">
                            <h3 class="card-title">{{ user.name }} {{ user.last_name }}</h3>
                            <h5 class="card-subtitle text-body-secondary my-1">{{ romanNum(user.grade) }} razred </h5>
                            <h6 class="card-subtitle text-body-secondary my-1">{{ user.major.name }} smjer</h6>
                            
                        </div>
                    </div>
    
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row my-3">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <nav  class="navbar nav bg-body-tertiary px-3 mb-3"> 
                    <li class="nav-item">
                        <Link class="nav-link fs-6 rounded" style="color: white; background: var(--gradient)"  :href="route('dashboard')">Zakazani termini <i class="bi bi-newspaper"></i></Link>
                    </li>
                    
                    <li class="nav-item">
                        <Link class="nav-link fs-6 text-body-secondary" :href="route('dashboard1')">Zakaži novi termin <i class="bi bi-plus-square text-primary"></i></Link>
                    </li>
                </nav>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row my-3">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="blur" style="width: 22rem; height: 30rem; left: 0;"></div>
                <h3>Poslati Zahtjevi</h3>

                <div v-if="requests.length === 0" class="alert alert-warning text-center">
                    Nema poslanih zahtjeva
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
                            <th scope="col">Opozovi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="request in requests" :key="request.id">
                            <td>
                                <img :src="getUserAvatar(request.tutor_id)" 
                                    alt="User Avatar" 
                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%">
                            </td>
                            <!-- Ime i Prezime -->
                            <td>{{ getUserFullName(request.tutor_id) }}</td>
                            
                            <!-- Razred -->
                            <td>{{ romanNum(getUserGrade(request.tutor_id)) }}</td>
                            
                            <!-- Predmet -->
                            <td>{{ getSubjectName(request.subject_id) }}</td>
                            
                            <!-- Detalji -->
                            <td>{{ request.details }}</td>
                            
                            <!-- Datum -->
                            <td>{{ formatDate(request.date) }}</td>
                            
                            <!-- Čas -->
                            <td>{{ request.hour_id }}.</td>
                            <td>
                                <button class="btn btn-sm btn-danger" @click="declineRequest(request)">X</button>
                            </td>
                            
                        </tr>
                    </tbody>
                </table>
                
                <h3>Zakazani termini</h3>


                <div v-if="schedules.length === 0" class="alert alert-warning text-center">
                    Nema zakazanih termina
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
                            <th scope="col">Opozovi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="request in schedules" :key="request.id">
                            <td>
                                <img :src="getUserAvatar(request.tutor_id)" 
                                    alt="User Avatar" 
                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%">
                            </td>
                            <!-- Ime i Prezime -->
                            <td>{{ getUserFullName(request.tutor_id) }}</td>
                            
                            <!-- Razred -->
                            <td>{{ romanNum(getUserGrade(request.tutor_id)) }}</td>
                            
                            <!-- Predmet -->
                            <td>{{ getSubjectName(request.subject_id) }}</td>
                            
                            <!-- Detalji -->
                            <td>{{ request.details }}</td>
                            
                            <!-- Datum -->
                            <td>{{ formatDate(request.date) }}</td>
                            
                            <!-- Čas -->
                            <td>{{ request.hour_id }}.</td>
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
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    requests: Array, 
    schedules: Array,
    users: Array,
    subjects: Array,
});


const form = useForm({
    user_id: null,
    tutor_id: null,
    date: null,
    hour_id: null,
});

const declineRequest = (request) => {
    form.user_id = props.user.id;
    form.tutor_id = request.tutor_id;
    form.date = request.date;
    form.hour_id = request.hour_id;
    
    form.delete(route('decline_request'), {
        preserveScroll: true,
        onSuccess: () => {
            alert('Zahtjev opozvan!');
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

const getUserAvatar = (userId) => {
    const user = props.users.find((u) => u.id === userId); 
    return user && user.avatar ? `../storage/${user.avatar}` : `../storage/avatars/default.jpg`;
};

// Function to get the user's grade
const getUserGrade = (userId) => {
    const user2 = props.users.find((u) => u.id === userId);  // Search the users array, not requests
    return user2 ? user2.grade : 'Unknown';
};

const getSubjectName = (subjectId) => {
    const subject = props.subjects.find((s) => s.id === subjectId);
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


</script>