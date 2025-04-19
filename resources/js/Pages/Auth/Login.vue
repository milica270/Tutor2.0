<template>
    <Head>
        <title>Login</title>
    </Head>
    <div class="container">
        <div class="row my-3">
            <h2 class="text-center mt-3 mb-3 fw-bold" style="font-size: 50px; color: var(--blue)">Prijava</h2>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="blur" style="width: 22rem; height: 30rem; left: 10rem;"></div>
                <form @submit.prevent="submit">
                    <TextInput name="Email" type="email" v-model="form.email" :message="form.errors.email"/>
                    <TextInput name="Lozinka" type="password" v-model="form.password" :message="form.errors.password"/>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" v-model="form.remember">
                        <label class="form-check-label fw-bold text-secondary" for="remember">Zapamti me</label>
                    
                    </div>
                    <div class="my-3">
                        <div class="d-flex">
                            <p class="text-dark fw-bold">Nemaš profil?</p>
                            <Link :href="route('register')" class="mx-2">Registruj se</Link>
                        </div>
                    </div>
                    <button type="submit" class="btn btn1 mt-3 form-control fw-bold" :disabled="form.processing">Prijava</button>
                </form>
            </div>
            <div class="col-md-3"></div>
            <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import TextInput from '../Components/TextInput.vue';


    const form = useForm({
        email: null,
        password: null,
        remember: null,
    });

    const submit = () => {
        form.post(route('authenticate'), {
            onError: () => form.reset('password', 'remember'),
        });
    };

</script>