<script>

    Vue.component('treeselect', VueTreeselect.Treeselect);
    Vue.use(DatePicker);
    Vue.component('money', money)

    var movement = new Vue({
        el: '#details',
        data: {
            errors: null,
            money: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                suffix: ' #',
                precision: 2,
                masked: false
            },
            details: [{
                id: null,
                date: new Date(1994, 12, 10),
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
            options: []
        },
        methods: {
            store() {
                this.errors = null;
                $.ajax({
                    url: 'store',
                    method: 'POST',
                    data: $("#w0").serializeArray()
                }).done(data => {

                }).fail(data => {
                    this.errors = $.parseJSON(data.responseText)
                })
            },
            addDetail: function (event) {
                event.preventDefault();
                this.details.push({
                    date: null,
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
                console.log(movement_id);

                if (movement_id !== -1) {
                    try {
                        let response = await fetch("get-movements-with-details?transfer_id=" + movement_id);
                        this.details = await response.json();
                        await this.details.map((detail) => {
                            let arrayDate = detail.date.split("-");
                            detail.date = new Date(arrayDate[0], arrayDate[1], arrayDate[2]);
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
                    let response = await fetch("get-all-activities?project_id=" + 3);
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
                    return sum + parseFloat(activity.amount)
                }, 0)
            },
            checkIfDateIsValid: function (value, index) {
                value = value.toISOString().slice(0, 10);
                fetch("validate-date?date=" + value + "&projectId=" + 3)
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
            this.getClassOptions();
            this.getAccountOptions();
            this.getActivityOptions();
            this.getBeneficiaries();
        }
    });
</script>