
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
          <div v-if="$page.props.auth.user.is_tutor === 0">
            <Link :href="route('tutors.create')" class="fs-5">Postani tutor →</Link>
          </div>
          <div v-else>
            <Link :href="route('tutor.dashboard')" class="fs-5">Tutor Stranica →</Link>
          </div>
        </div>
      </div>
      <div class="blur" style="width: 22rem; height: 30rem; left: 0;"></div>

      <div class="row my-3">
            <div class="col-md-1"></div>
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-1">
                    <img class="card-img-top mx-2"
                         :src="user.avatar ? ('storage/' + user.avatar) : ('storage/avatars/default.jpg')"
                         alt=""
                         style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%">
                    <div class="card-body">
                        <h3 class="card-title">{{ user.name }} {{ user.last_name }}</h3>
                        <h5 class="card-subtitle text-body-secondary my-1">{{ romanNum(user.grade) }} razred</h5>
                        <h6 class="card-subtitle text-body-secondary my-1">
                            {{ user.major ? user.major.name : 'Nema smjera' }} smjer
                        </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row my-3">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <nav class="navbar nav bg-body-tertiary px-3 mb-3">
                    <li class="nav-item">
                        <Link class="nav-link fs-6 text-body-secondary" :href="route('dashboard')">
                            Zakazani termini <i class="bi bi-newspaper text-primary"></i>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link fs-6 rounded" style="color: white; background: var(--gradient)"
                              :href="route('dashboard1')">Zakaži novi termin <i class="bi bi-plus-square"></i>
                        </Link>
                    </li>
                </nav>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
      <div class="row my-3">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <h3 class="mb-3">Rezultati pretrage</h3>
          <div v-if="tutors.length === 0" class="alert alert-warning text-center my-3">
            Nema pronađenih tutora.
          </div>
          <div v-else class="row">
            <div class="col-md-4 mb-3" v-for="tutor in tutors" :key="tutor.id">
              <div class="card shadow-sm" style="border-radius: 15px;">
                <img :src="tutor.avatar ? ('storage/' + tutor.avatar) : ('storage/avatars/default.jpg')"
                     class="card-img-top"
                     alt="Tutor Image"
                     style="width: 100%; height: 200px; object-fit: cover; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <div class="card-body text-center" style="background-color: whitesmoke">
                  <h5 class="card-title fw-bold">{{ tutor.name }} {{ tutor.last_name }}</h5>
                  <p class="card-text text-muted my-2"><strong>{{ romanNum(tutor.grade) }}</strong> razred</p>
                  <p class="card-text text-muted my-2"><strong>{{ tutor.major.name }}</strong> smjer</p>
  
                  <div>
                    <div class="fw-bold">Izaberite slobodan termin:</div>
                    <div v-for="(datePair, index) in tutor.first_available_date" :key="index" class="form-check">
                      <input type="radio" 
                             class="form-check-input custom-radio" 
                             :id="'date_' + tutor.id + '_' + index" 
                             :name="'tutor_' + tutor.id" 
                             :value="datePair.date + ' ' + datePair.hour_id"
                             v-model="tutor.selected_date">
                      <label class="form-check-label" :for="'date_' + tutor.id + '_' + index">
                        {{ datePair.date }}, {{ datePair.hour_id }}. čas
                      </label>
                    </div>
                  </div>
  
                  <div class="d-flex justify-content-center">
                    <span v-for="star in tutor.subject_grade" :key="star">
                      <i class="bi bi-star-fill mx-1" style="color: orange; font-size: 1.2rem;"></i>
                    </span>
                  </div>
  
                 
                  <form @submit.prevent="submitRequest(tutor)" >
                    <div :class="{ 'disabled-overlay': form.processing }">
                        <button  class="btn btn-sm btn-primary fw-bold my-3" :disabled="form.processing">Pošaljite zahtjev</button>
                    </div>
                    
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-1"></div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { useForm } from '@inertiajs/vue3';
  
  const props = defineProps({
    user: Object,
    tutors: Object,
    details: String,
    subject: String,
  });


  const form = useForm({
    tutor_id: null,
    user_id: null,
    date: null,
    hour_id: null,
    subject_id: null,
    details: null,
});
  
  function romanNum(num) {
    if(num === 1) {
      return 'I';
    } else if(num === 2) {
      return 'II';
    } else if(num === 3) {
      return 'III';
    } else {
      return 'IV';
    }
  }
  
  const submitRequest = (tutor) => {
    if (!tutor.selected_date) {
        alert("Molimo vas da izaberete termin pre slanja zahteva.");
        return;
    }

    form.tutor_id = tutor.id;
    form.user_id =  props.user.id; 
    form.date = tutor.selected_date.split(' ')[0];
    form.hour_id = tutor.selected_date.split(' ')[1];
    form.subject_id = parseInt(props.subject, 10);
    form.details = props.details;

    form.post(route('send_request'), {
        preserveScroll: true,
    });
  
    
  };
  </script>
  