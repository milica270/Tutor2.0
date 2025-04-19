<template>
    <Head>
        <title>Add Admin</title>
    </Head>
    <div class="container">
        <div class="blur" style="width: 22rem; height: 30rem; left: 0;"></div>
        <div class="row my-3">
            <h2 class="text-center mt-3 mb-3 fw-bold" style="font-size: 50px; color: var(--blue)">Admin Panel</h2>
        </div>
        <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
        <div class="row my-3">
            <div class="col-md-1"></div>
        <div class="col-md-10">
            <nav class="navbar nav bg-body-tertiary px-3 mb-3"> 
                <li class="nav-item">
                    <Link class="nav-link fs-6 rounded" style="color: white; background: var(--gradient)" :href="route('admin1')">Dodaj/Ukloni Admina <i class="bi bi-people-fill text-secondary"></i></Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link fs-6 text-body-secondary" :href="route('admin2')">Tutori <i class="bi bi-blockquote-right text-primary"></i></Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link fs-6 text-body-secondary"  :href="route('admin3')">Studenti <i class="bi bi-chat-dots-fill text-primary"></i></Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link fs-6 text-body-secondary" :href="route('admin5')">Istorija <i class="bi bi-clock-history text-primary"></i></Link>
                </li>
            </nav>
        </div>
        <div class="col-md-1"></div>
        </div>
        <div class="row my-3">
            <h3 style="color: var(--darkGrey)">Dodaj admina</h3>
            <form class="d-flex mb-3 gap-2" @submit.prevent="submit">
                <input v-model="form.email" class="form-control" type="text" placeholder="Unesi email novog admina">
                <button type="submit" class="btn btn1" :disabled="form.processing">Dodaj</button>
            </form>

        </div>
        <div class="row my-3">
            <h3 style="color: var(--darkGrey)">Ukloni admina</h3>
            <form class="d-flex mb-3 gap-2" @submit.prevent="submit1">
                <input v-model="form1.email" class="form-control" type="text" placeholder="Unesi email admina kojeg želite ukloniti">
                <button type="submit" class="btn btn1" :disabled="form1.processing">Ukloni</button>
            </form>
            
        </div>
        <div class="row my-3">
            <div v-if="$page.props.flash.message" class="alert alert-primary alert-dismissible my-2">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                {{ $page.props.flash.message }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';



    const form = useForm({
        email: null,
    });

    const form1 = useForm({
        email: null,
    });

    const submit = () => {
        form.put(route('add.admin'), {
        onSuccess: () => {
            form.email = '';
        },
        preserveScroll: true, 
    });
    };

    const submit1 = () => {
        form1.put(route('delete.admin'), {
        onSuccess: () => {
            form1.email = '';
        },
        preserveScroll: true, 
    });
    };

</script>