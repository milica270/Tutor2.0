<template>
    <Head>
        <title>History</title>
    </Head>
    <div class="container">
        <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
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
                    <Link class="nav-link fs-6 text-body-secondary"  :href="route('admin2')">Tutori <i class="bi bi-blockquote-right text-secondary"></i></Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link fs-6 text-body-secondary" :href="route('admin3')">Studenti <i class="bi bi-chat-dots-fill text-primary"></i></Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link fs-6 rounded" style="color: white; background: var(--gradient)"  :href="route('admin5')">Istorija <i class="bi bi-clock-history text-primary"></i></Link>
                </li>
            </nav>
        </div>
        <div class="col-md-1"></div>
        </div>
        <div class="row my-3">
            <div class="d-flex justify-content-between align-center">
                <h3 style="color: var(--darkGrey)">Istorija časova</h3>
                <h5>Ukupno: {{ cnt }}</h5>
            </div>
            <div>
                            
                            <table class="table table-secondary table-bordered table-striped table-hover" style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                                <thead class="">
                                    <tr>
                                        <th scope="col">Ime tutora</th>
                                        <th scope="col">Ime studenta</th>
                                        <th scope="col">Predmet</th>
                                        <th scope="col">Datum</th>
                                        <th scope="col">Čas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="sh in schedules.data" :key="sh.id">
                                        
                                        <td>{{ getUserName(sh.tutor_id) }}</td>
                                        <td>{{ getUserName(sh.user_id) }}</td>
                                        <td>{{ getSubjectName(sh.subject_id) }}</td>
                                        <td>{{ formatDate(sh.date) }}</td>
                                        <td>{{ sh.hour_id }}.</td>
                                        
                                        
                                    </tr>
                                </tbody>
                            </table>
                            <div>
                                <Link preserve-scroll v-for="link in schedules.links" :key="link.label" v-html="link.label" :href="link.url" :class="{'text-secondary' : !link.url, 'text-primary fw-bold' : link.active}" class="p-1 mx-1" style="text-decoration: none"></Link>
                                <p>Showing {{ schedules.from }} to {{ schedules.to }} of {{ schedules.total }} results.</p>
                            </div> 
                    </div>
        </div>
        <div class="blur" style="width: 22rem; height: 30rem; left: 0;"></div>
    </div>
</template>

<script setup>



const props = defineProps({
  schedules: Object,
  users: Array,
  subjects: Array,
  cnt: Number,
});


const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Intl.DateTimeFormat('en-US', options).format(date);
};




const getUserName = (Id) => {
  const tutor = props.users.find(user => user.id === Id);
  return tutor ? `${tutor.name} ${tutor.last_name}` : 'Unknown';
};



const getSubjectName = (subjectId) => {
  const subject = props.subjects.find(sub => sub.id === subjectId);
  return subject ? subject.name : 'Unknown';
};


</script>