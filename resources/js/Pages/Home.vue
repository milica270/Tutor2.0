<script setup lang="ts">
import { route } from 'ziggy-js';

</script>


<template>
    <Head>
        <title>Home</title>
    </Head>
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center">
                <div class="blur" style="width: 22rem; height: 30rem; left: 0;"></div>
                <div class="d-flex flex-column gap-5">
                    <div>
                    <h1 style="font-size: 80px; margin: 0" class="fw-bold">Tutor <span style="color: var(--blue); ">2</span>.0</h1>
                    
                    <h4 style="margin: 0; color: var(--darkGrey)">Povezuje učenike kojima je potrebna pomoć u učenju s vršnjacima koji su izvrsni u određenim predmetima. </h4>
                    </div>
                    <div class="d-flex my-4" v-if="!$page.props.auth.user">
                        <button style="margin-right: 120px" class="btn btn1 btn-lg"><Link class="link_style" :href="route('register')">Registracija</Link></button>
                        <button class="btn btn1 btn-lg"><Link class="link_style" :href="route('login')">Prijava</Link></button>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div style="height: 100vh; background: url('https://static.vecteezy.com/ti/vecteur-libre/t1/23493444-une-ligne-continue-dessine-des-enfants-eleves-qui-etudient-ensemble-pendant-que-le-garcon-explique-a-la-fille-en-montrant-leur-cahier-les-enfants-font-leurs-devoirs-a-l-ecole-illustration-graphiquele-de-conception-a-une-seule-ligne-vectoriel.jpg') no-repeat center center/cover;">
                </div>
                
            </div>
            
        </div>
        
    </div>
</template>


<style>

.dropdown-menu .dropdown-item:hover {
    background-color: var(--darkBlue);
    color: #fff; 
}

</style>