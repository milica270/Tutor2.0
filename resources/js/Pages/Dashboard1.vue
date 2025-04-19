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
            <div class="blur" style="width: 22rem; height: 30rem; left: 0;"></div>
        </div>
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
                    <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row my-3">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <nav class="navbar nav bg-body-tertiary px-3 mb-3"> 
                    <li class="nav-item">
                        <Link class="nav-link fs-6 text-body-secondary" :href="route('dashboard')">Zakazani termini <i class="bi bi-newspaper text-primary"></i></Link>
                    </li>
                    
                    <li class="nav-item">
                        <Link class="nav-link fs-6 rounded" style="color: white; background: var(--gradient)" :href="route('dashboard1')">Zakaži novi termin <i class="bi bi-plus-square"></i></Link>
                    </li>
                </nav>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row my-3">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <h3>Zakaži novi termin</h3>


                <form @submit.prevent="find">
                    <!-- Subject Select -->
                    <div class="mb-3">
                        <label for="subjects" class="form-label fw-bold text-secondary">
                            Predmet sa kojim imaš problem:
                        </label>
                        <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
                        <select id="subjects" class="form-select" v-model="form.subject">
                            <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                {{ subject.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Details Textarea -->
                    <div class="mb-3">
                        <label for="details" class="form-label fw-bold text-secondary">
                            Pojasni šta tačno želiš da učiš sa tutorom:
                        </label>
                        <textarea
                            id="details"
                            class="form-control"
                            rows="5"
                            v-model="form.details"
                            placeholder="Unesi detalje..."
                            style="resize: none"
                        ></textarea>
                    </div>
                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn1">
                            Pronađi Tutore <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                


            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    subjects: Array,
});

const form = useForm({
    subject: null,
    details: null,
});


function find() {
    if (!form.subject || !form.details) {
        alert("Molimo popunite sva polja.");
        return;
    }

    
    form.get(route('tutors.results'), {
        onSuccess: () => {
            form.subject = '';
            form.details = '';
        },
        preserveScroll: true, 
    });
}

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