
<template>
    <Head>
        <title>New Subjects</title>
    </Head>
    <div class="container">
        <div class="row d-flex align-items-center my-3">
            <div class="col-md-3 d-flex justify-content-end">
                <div>
                    <Link :href="route('tutor.dashboard')" class="fs-5"><-Tutor Stranica</Link>
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="text-center mt-3 mb-3 fw-bold" style="font-size: 50px; color: var(--blue)">Dodaj Predmete</h2>
            </div>
            <div class="blur" style="width: 22rem; height: 30rem; left: 0;"></div>
            <div class="col-md-3"></div>
        </div>
        <div class="row my-3">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
                <div 
                    v-for="(subjectForm, index) in subjectForms" 
                    :key="index" 
                    class="my-3" 
                    style="border: 1px solid var(--darkGrey); border-radius: 10px; padding: 10px"
                >
                    <h5 style="color: var(--darkGrey)">Predmet {{ index + 1 }}</h5>
                    
                        <div class="d-flex align-items-center gap-4 justify-content-center">
                            <div>
                                <div class="my-3">
                                    <label for="subjects" class="form-label fw-bold text-secondary">
                                        Predmet koje želiš da podučavaš:
                                    </label>
                                    <select 
                                        id="subjects" 
                                        class="form-select" 
                                        v-model="subjectForm.subjectId"
                                        required
                                    >
                                        <option 
                                            v-for="subject in subjects" 
                                            :key="subject.id" 
                                            :value="subject.id"
                                        >
                                            {{ subject.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="d-flex gap-3">
                                    <label for="grade" class="form-label fw-bold text-secondary">
                                        Ocjena koju imaš iz tog predmeta:
                                    </label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input 
                                                class="form-check-input" 
                                                type="radio" 
                                                :name="'grade-' + index" 
                                                id="'grade4-' + index" 
                                                value="4" 
                                                v-model="subjectForm.subject_grade"
                                                required
                                            />
                                            <label class="form-check-label" :for="'grade4-' + index">4</label>
                                        </div>
                                        <div class="form-check">
                                            <input 
                                                class="form-check-input" 
                                                type="radio" 
                                                :name="'grade-' + index" 
                                                id="'grade5-' + index" 
                                                value="5" 
                                                v-model="subjectForm.subject_grade"
                                                required
                                            />
                                            <label class="form-check-label" :for="'grade5-' + index">5</label>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-danger" style="font-size: 15px">
                                    *Minimalna ocjena koju moraš imati da bi bio tutor je 4.
                                </p>
                            </div>
                        </div>
                    
                </div>
                <div class="d-flex gap-3 mt-3 justify-content-center">
                    <button 
                        class="btn btn-success fw-bold" 
                        @click="addSubjectForm"
                    >
                        +
                    </button>
                    <button 
                        class="btn btn-danger fw-bold" 
                        @click="removeLastSubjectForm" 
                        :disabled="subjectForms.length === 1"
                    >
                        -
                    </button>
                </div>
                <button 
                    class="btn btn1 mt-5" 
                    style="width: 100%" 
                    @click="submit"
                >
                    Pošalji
                </button>
                <div class="blur" style="width: 22rem; height: 30rem; right: 0;"></div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</template>

<script setup>
import { reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    subjects: Object,
});

const subjectForms = reactive([
    {
        subjectId: null,
        subject_grade: null,
    },
]);

const addSubjectForm = () => {
    subjectForms.push({
        subjectId: null,
        subject_grade: null,
    });
};

const removeLastSubjectForm = () => {
    if (subjectForms.length > 1) {
        subjectForms.pop();
    }
};

const submit = () => {

    const isFormValid = subjectForms.every(
        (form) => form.subjectId !== null && form.subject_grade !== null
    );

    if (!isFormValid) {
        alert("Molimo popunite sve predmete i ocene pre slanja.");
        return;
    }
    const selectedSubjects = subjectForms.map((form) => form.subjectId);
    const hasDuplicates = new Set(selectedSubjects).size !== selectedSubjects.length;

    if (hasDuplicates) {
        alert("Ne možete odabrati isti predmet više puta. Molimo promenite izbor.");
        return;
    }
    console.log("Submitting subjects:", subjectForms);

    const form = useForm({
        subjects: subjectForms,
    });

    form.post(route('submit.tutor.subjects'), {
        onSuccess: () => {
            console.log("Subjects added successfully!");
            subjectForms.splice(0, subjectForms.length, {
                subjectId: null,
                subject_grade: null,
            });
            alert('Uspješno poslati zahtjevi!')
        },
    });
};
</script>