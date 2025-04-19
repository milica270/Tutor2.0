<template>
    <Head>
        <title>Register</title>
    </Head>
    <div class="container">
        <div class="row my-3">
            <h2 class="text-center mt-3 mb-3 fw-bold" style="font-size: 50px; color: var(--blue)">Registracija</h2>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
            <form @submit.prevent="submit">
                <div class="d-flex justify-content-between align-items-center">
                    <div style="width: 45%">
                        
                
                    <div class="d-flex justify-content-left align-items-center">
                        <div class="text-center p-3 border-secondary bg-secondary" style="width: 140px; height: 140px; position: relative; border-radius: 0; border: 2px solid">
                            <label class="form-label text-secondary fw-bold text-center" style="background-color: white;z-index: 1; position: absolute; top: 100px; text-align: center; left:0; right: 0" for="avatar">
                                <span class="" style="top: 120px; cursor: pointer">Slika</span>
                            </label>
                            <input class="form-control" type="file" id="avatar" hidden @input="change">
                            <img :src="form.preview ?? '../../../../public/storage/avatars/default.jpg'" alt="" class="img-fluid" style="border-radius: 50%;  position: absolute; top: 0; left: 0; object-fit: cover; width: 100%; height: 100%">
                            
                        </div>
                    <p>{{ form.errors.avatar }}</p>
                    </div>
                    <TextInput name="Ime" v-model="form.name" :message="form.errors.name"/>
                    <div class="blur" style="width: 22rem; height: 30rem; left: 0;"></div>
                    <TextInput name="Prezime" v-model="form.last_name" :message="form.errors.last_name"/>
                    <label for="grade" class="form-label fw-bold text-secondary">Razred</label>
                    <select class="form-select" id="grade" v-model="form.grade">
                        <option value="1">I</option>
                        <option value="2">II</option>
                        <option value="3">III</option>
                        <option value="4">IV</option>
                    </select>
                    <label for="major_id" class="form-label fw-bold text-secondary">Smjer</label>
                    <select class="form-select" id="major_id" v-model="form.major_id">
                        <option value="1">Opšti smjer</option>
                        <option value="2">Društveno-jezički smjer</option>
                        <option value="3">Računarsko-informatički smjer</option>
                    </select>
                    </div>
                    <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
                    <div style="width: 45%">
                        <TextInput name="Email" type="email" v-model="form.email" :message="form.errors.email"/>
                    <TextInput name="Lozinka" type="password" v-model="form.password" :message="form.errors.password"/>
                    <TextInput name="Potvrdi lozinku" type="password" v-model="form.password_confirmation" />
                    <div class="my-3">
                        <div class="d-flex">
                            <p class="fw-bold text-dark">Imaš profil?</p>
                            <Link :href="route('login')" class="mx-2">Prijava</Link>
                        </div>
                    </div>
                    <button type="submit" class="btn btn1 mt-3 form-control fw-bold" :disabled="form.processing">Registruj se</button>
               
                    </div>
                
                </div>
                
            </form>
        </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import TextInput from '../Components/TextInput.vue';


    const form = useForm({
        name: null,
        last_name: null,
        grade: null,
        major_id: null,
        email: null,
        password: null,
        password_confirmation: null,
        avatar: null,
        preview: null,
    });

    const submit = () => {
        form.post(route('store'), {
            onError: () => form.reset('password', 'password_confirmation'),
        });
    };

    const change = (e) => {
        form.avatar = e.target.files[0];
        form.preview = URL.createObjectURL(e.target.files[0]);
    };

</script>