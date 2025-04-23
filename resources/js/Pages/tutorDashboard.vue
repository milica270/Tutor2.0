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
            </div>
            <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
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
            <div class="col-md-1"></div>
        </div>

        <div class="row my-3">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <nav class="navbar nav bg-body-tertiary px-3 mb-3"> 
                    <li class="nav-item">
                        <Link class="nav-link fs-6 rounded" style="color: white; background: var(--gradient)" :href="route('tutor.dashboard')">Termini <i class="bi bi-newspaper"></i></Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link fs-6 text-body-secondary" :href="route('tutor.dashboard1')">Zahtjevi <i class="bi bi-envelope text-primary"></i></Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link fs-6 text-body-secondary" :href="route('tutor.dashboard2')">Raspored <i class="bi bi-table text-primary"></i></Link>
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
                <div class="blur" style="width: 22rem; height: 30rem; left: 0;"></div>
                <h3>Termini</h3>

                <div class="d-flex flex-wrap gap-3 my-3">
                    <div 
                        v-for="appointment in appointments" 
                        :key="appointment.id" 
                        class="card shadow-sm p-3 rounded text-center position-relative" 
                        style="width: 120px; border: 1px solid var(--blue);"
                    >
                       
                        <button 
                            class="btn-close position-absolute" 
                            style="top: 5px; right: 5px;" 
                            @click="deleteAppointment(appointment.id)" 
                            aria-label="Close">
                        </button>

                       
                        <div class="fw-bold" style="font-size: 20px; color: var(--blue);">
                            {{ appointment.hour_id }}. čas
                            
                        </div>
                        <div class="my-2">
                            {{getHour(appointment.hour_id)}}
                        </div>

                       
                        <div class="text-muted" style="font-size: 16px;">
                            {{ days[appointment.day - 1] }}
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <h4 class="card-title text-center fw-bold">Dodaj novi termin</h4>
                        <form @submit.prevent="submitForm">
                          
                            <div class="mb-3">
                                <label for="hour" class="form-label fw-bold">Izaberi čas:</label>
                                <select v-model="form.hour_id" id="hour" class="form-select" required>
                                    <option value="" disabled>Izaberi čas</option>
                                    <option v-for="hour in hours" :key="hour.id" :value="hour.id">
                                        {{ hour.start }} - {{ hour.end }} ({{ hour.id }}. čas)
                                    </option>
                                </select>
                            </div>
                            <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
                          
                            <div class="mb-3">
                                <label for="day" class="form-label fw-bold">Odaberi dan:</label>
                                <select v-model="form.day" id="day" class="form-select" required>
                                    <option value="" disabled>Odaberi dan</option>
                                    <option v-for="(day, index) in days" :key="index" :value="index + 1">{{ day }}</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn1 w-100">Dodaj</button>
                        </form>
                    </div>
                </div>
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
    appointments: Array,
    scheduleCount: Number 
});


const form = useForm({
    hour_id: null,
    day: null,
});

const hours = [
    { id: 1, start: "07:30", end: "08:15" },
    { id: 2, start: "08:20", end: "09:05" },
    { id: 3, start: "09:10", end: "09:55" },
    { id: 4, start: "10:10", end: "10:55" },
    { id: 5, start: "11:00", end: "11:45" },
    { id: 6, start: "11:50", end: "12:35" },
    { id: 7, start: "12:40", end: "13:25" },
    { id: 8, start: "13:30", end: "14:15" },
];

const days = ["Ponedeljak", "Utorak", "Srijeda", "Četvrtak", "Petak"];

function getHour(hourId) {
    const hour = hours.find((h) => h.id === hourId);
    return hour ? `${hour.start} - ${hour.end}` : "Nepoznato";
}

function submitForm() {
    form.post(route('store_new_appointment'), {
        preserveScroll: true,
        onSuccess: () => {
            alert('Uspješno ste dodali termin.');
            form.hour_id = '';
            form.day = '';
            form.reset({ hour_id: null, day: null });
        },
        onError: (errors) => {
            alert('Došlo je do greške.');
            form.reset({ hour_id: null, day: null });
        },
    });
}

function deleteAppointment(id) {
    if (confirm('Da li ste sigurni da želite obrisati ovaj termin?')) {
        form.delete(route('delete_appointment', id), {
            onSuccess: () => {
                alert('Termin je uspješno obrisan.');
            },
            onError: () => {
                alert('Došlo je do greške prilikom brisanja termina.');
            },
        });
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
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            modal.hide();
        },
    });
};

const deleteSubject = (userId, subjectId) => {
    router.put(route('delete_subject_from_tutor', { id: userId, subject_id: subjectId }), {
        onSuccess: () => {
            alert('Uspješno ste uklonili predmet od tutora!');
           
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            modal.hide();
        },
    });
};
</script>
