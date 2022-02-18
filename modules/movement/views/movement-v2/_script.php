<script>
    Vue.component('treeselect', VueTreeselect.Treeselect);
    Vue.use(DatePicker);
    Vue.use('v-money', {precision: 4})

    var movement = new Vue({
        el: '#details',
        data: {
            errors: false,
            money: {
                decimal: '.',
                thousands: ',',
                precision: 2,
                masked: false
            },
            details: [{
                id: null,
                date: new Date(),
                benefiaciary: null,
                concept: null,
                kind: null,
                sub_details: [
                    {
                        id: null,
                        sub_category_id: null,
                        class_id: null,
                        account: null,
                        amount: 0
                    }
                ]
            }],
            kindOptions: [
                {
                    id: 'Ingreso',
                    'label': 'Ingreso'
                },
                {
                    id: 'Egreso',
                    'label': 'Egreso'
                },
                {
                    id: 'Comision Bancaria',
                    'label': 'Comision Banacaria'
                }
            ],
            class_options: [],
            account_options: [],
            activity_options: [],
            beneficiaries_options: [],
            project_options: [],
            options: [],
            project_id: null,
            has_v2: null
        },
        methods: {
            onChange() {
                console.log(event.target.value + 'Siu');
            },
            storeBeneficiary() {
                $.ajax({
                    url: 'store-beneficiary',
                    method: 'POST',
                    data: {name: document.getElementById('new_beneficiary').value}
                }).done(data => {
                    document.getElementById('exampleModal').click();
                    this.getBeneficiaries();
                }).fail(data => {
                    this.errors = $.parseJSON(data.responseText)
                })
            },
            store() {
                this.errors = null;
                $.ajax({
                    url: 'store',
                    method: 'POST',
                    data: $("#w0").serializeArray()
                }).done(data => {
                   // window.location.href = "other-create";
                }).fail(data => {
                    this.errors = $.parseJSON(data.responseText)
                })
            },
            addDetail: function (event) {
                event.preventDefault();
                this.details.push({
                    date: new Date(),
                    benefiaciary: '',
                    concept: '',
                    kind: '',
                    sub_details: [
                        {
                            id: null,
                            sub_category_id: null,
                            class_id: null,
                            account: null,
                            amount: 0
                        }
                    ]
                });
            },
            addNewSubCategory: function (index) {
                event.preventDefault();
                this.details[index].sub_details.push({
                    budget: '',
                    category: '',
                    sub_category: '',
                    amount: 0
                })
            },
            deleteSubItem: function (indexSubDetail, index) {
                event.preventDefault();
                this.details[index].sub_details.splice(indexSubDetail, 1);
            },
            async getValues() {
                let movement_id = document.getElementById('movement_id').value;
                this.project_id = document.getElementById('project_id').value;
                this.has_v2 = document.getElementById('has_v2').value;

                console.log(this.has_v2);

                if (movement_id !== -1) {
                    try {
                        let response = await fetch("get-movements-with-details?transfer_id=" + movement_id + "&has_v2=" + this.has_v2);
                        this.details = await response.json();
                        await this.details.map((detail) => {
                            let arrayDate = detail.date.split("-");
                            detail.date = new Date(arrayDate[0], (arrayDate[1] - 1), arrayDate[2]);
                        });
                    } catch (error) {
                        console.log(error);
                    }
                }
            },
            async getClassOptions() {
                try {
                    let response = await fetch("get-all-classes");
                    this.class_options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getProjectOptions() {
                try {
                    let response = await fetch("get-all-project");
                    this.project_options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getAccountOptions() {
                try {
                    let response = await fetch("get-all-accounts");
                    this.account_options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getActivityOptions() {
                try {
                    let response = await fetch("get-all-activities?project_id=" + this.project_id);
                    this.activity_options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getBeneficiaries() {
                try {
                    let response = await fetch("get-all-beneficiaries");
                    this.beneficiaries_options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            sumAmount: function (activities) {
                return activities.reduce((sum, activity) => {
                    let value = parseFloat(sum + parseFloat(activity.amount));
                    return value;
                }, 0)
            },
            checkIfDateIsValid: function (value, index) {
                value = value.toISOString().slice(0, 10);
                fetch("validate-date?date=" + value + "&projectId=" + this.project_id)
                    .then(response => response.json())
                    .then((response) => {
                        if (response.isValid === false) {
                            Swal.fire({
                                text: 'La fecha indicada, no esta dentro del periodo de ejecución actual',
                                icon: 'warning',
                                confirmButtonText: 'Aceptar'
                            })
                        }
                    })
                    .catch(error => console.error('Error:', error))
            },
        },
        created() {
            this.getValues();
            this.getProjectOptions();
            this.getClassOptions();
            this.getAccountOptions();
            this.getActivityOptions();
            this.getBeneficiaries();
        },
        watch: {
            project_id: function () {
                this.getActivityOptions();
            }
        }
    });
</script>