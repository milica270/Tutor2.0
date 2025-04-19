<template>
    <Head>
        <title>Tutors</title>
    </Head>
    <div class="container">
        <div class="row my-3">
            <h2 class="text-center mt-3 mb-3 fw-bold" style="font-size: 50px; color: var(--blue)">Admin Panel</h2>
        </div>
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
        <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
        <div class="col-md-1"></div>
        </div>
        <div class="row my-3">
                <Link class="" style="text-decoration: none" :href="route('admin2')"><h3 style="color: var(--darkGrey)">-Tabela Tutora</h3></Link>
                <Link class="" style="" :href="route('admin4')"><h3 style="color: var(--darkGrey)">-Novi Zahtjevi</h3></Link>
                <div class="blur" style="width: 22rem; height: 30rem; left: 0;"></div>
        </div>
        <div class="row my-3">
                <table class="table table-secondary table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                        <th>Slika</th>
                        <th>Ime i prezime</th>
                        <th>Predmet</th>
                        <th>Ocjena</th>
                        <th>Prihvati</th>
                        <th>Odbij</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="subject in tutorSubjects" :key="subject.id">
                        <td>
                            <img :src="getTutorAvatar(subject.tutor_id)" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%">
                        </td>
                        <td>{{ getTutorName(subject.tutor_id) }}</td>
                        <td>{{ getSubjectName(subject.subject_id) }}</td>
                        <td>{{ subject.subject_grade }}</td>
                        <td>
                            <button 
                                class="btn btn-sm btn-success" 
                                @click="() => acceptTutor(subject.id)">
                                <i class="bi bi-check-lg"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-danger"
                            @click="() => refuseTutor(subject.id)">X</button>
                        </td>
                        </tr>
                    </tbody>
                </table>
            
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';



const props = defineProps({
  tutorSubjects: Array,
  users: Array,
  subjects: Array
});



const form = useForm({
  id1: null, // This will store the ID of the subject being updated
});

const form1 = useForm({
  id2: null, 
});

// Function to accept a tutor subject
const acceptTutor = (id) => {
    form.id1 = id;
  form.put(route('accept.tutor'), {
    preserveScroll: true, // Optional: Prevent page from scrolling
    onSuccess: () => {
      
      alert('Uspješno ste prihvatili zahtjev. Novi tutor dodat.');
    },
    onError: (errors) => {
      alert('Došlo je do greške.');
    },
  });
};


const refuseTutor = (id) => {
    form1.id2 = id;
    form1.delete(route('refuse.tutor'), {
    preserveScroll: true, 
    onSuccess: () => {
      
      alert('Uspješno ste odbili zahtjev.');
    },
    onError: (errors) => {
      alert('Došlo je do greške.');
    },
  });
};




const getTutorAvatar = (tutorId) => {
  const tutor = props.users.find(user => user.id === tutorId);
  // Check if the avatar exists and return the correct path
  return tutor.avatar ? `/storage/${tutor.avatar}` : '/storage/avatars/default.jpg';
};


// Helper function to get tutor name
const getTutorName = (tutorId) => {
  const tutor = props.users.find(user => user.id === tutorId);
  return tutor ? `${tutor.name} ${tutor.last_name}` : 'Unknown';
};

const getSubjectName = (subjectId) => {
  const subject = props.subjects.find(sub => sub.id === subjectId);
  return subject ? subject.name : 'Unknown';
};


</script>