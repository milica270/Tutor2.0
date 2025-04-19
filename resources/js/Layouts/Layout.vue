<template>
    <Head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    </Head>
    <nav class="navbar" style="background-color: var(--darkGrey)">
        <div class="container">
            <Link class="navbar-brand" href="/">
                <img style="border-radius: 20px" src="/public/storage/images/logo.jpg" alt="Bootstrap" width="50" height="40">
            </Link>
            <div class="d-flex gap-4 align-items-center" v-if="$page.props.auth.user">
                <div v-if="($page.props.auth.user.is_admin) === 1">
                    <Link class="link_style" :href="route('admin1')">Admin</Link>
                </div>
                <Link :href="route('dashboard')"><i style="color: white" class="fw-bold fs-3 bi bi-house-door-fill"></i></Link>
                
                <Link :href="route('logout')" method="post" class="btn btn-danger btn-sm fw-bold">Odjava</Link>
            </div>
            
           
        </div>
    </nav>
    <main>
        <slot></slot>
    </main>
</template>
<script setup>

</script>