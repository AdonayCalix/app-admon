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
                beneficiary_label: 'Beneficiario',
                benefiaciary: null,
                concept: null,
                kind: 'Egreso',
                amount: 0,
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
                    id: 'Egreso',
                    'label': 'Egreso (Cheque/Tb)'
                },
                {
                    id: 'Ingreso',
                    'label': 'Reintegro'
                },
                {
                    id: 'Comision Bancaria',
                    'label': 'Comision Bancaria'
                },
                {
                    id: 'Deposito',
                    label: 'Deposito'
                }
            ],
            class_options: [],
            account_options: [],
            activity_options: [],
            beneficiaries_options: [],
            project_options: [],
            options: [],
            project_id: null,
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
                console.log($("#w0").serializeArray());
                $.ajax({
                    url: 'store',
                    method: 'POST',
                    data: $("#w0").serializeArray()
                }).done(data => {
                    window.location.href = "other-create";
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
                    beneficiary_label: 'Beneficiario',
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
                });
            },
            deleteSubItem: function (indexSubDetail, index) {
                event.preventDefault();
                this.details[index].sub_details.splice(indexSubDetail, 1);
            },
            deleteItem: function (index) {
                event.preventDefault();

                let detail_id = this.details[index].id;

                if (detail_id == null) {
                    this.details.splice(index, 1);
                } else {
                    Swal.fire({
                        title: '¿Deseas eliminar este movimiento?',
                        text: "Se borrara el registro de la base de datos!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, eliminar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            fetch("delete-movement-detail?id=" + detail_id)
                                .then(response => response.json())
                                .then((response) => {
                                    Swal.fire(
                                        'Eliminado!',
                                        'Se ha eliminado el moviemiento correctamente.',
                                        'success'
                                    );

                                    this.details.splice(index, 1);
                                })
                                .catch(error => console.error('Error:', error));
                        }
                    })
                }
            },
            async getValues() {
                let movement_id = document.getElementById('movement_id').value;
                this.project_id = document.getElementById('project_id').value;
                console.log(movement_id);

                if (movement_id != -1) {
                    try {
                        let response = await fetch("get-movements-with-details?transfer_id=" + movement_id);
                        this.details = await response.json();
                        await this.details.map((detail) => {

                            if (detail.kind == 'Egreso') detail.beneficiary_label = 'Beneficiario';
                            if (detail.kind == 'Comision Bancaria') detail.beneficiary_label = 'Beneficiario';
                            if (detail.kind == 'Deposito') detail.beneficiary_label = 'Remitente';
                            if (detail.kind == 'Ingreso') detail.beneficiary_label = 'Remitente';

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
            changeBeneficiaryLabel: function (kind, index) {

                if (kind == 'Egreso') this.details[index].beneficiary_label = 'Beneficiario';
                if (kind == 'Comision Bancaria') this.details[index].beneficiary_label = 'Beneficiario';
                if (kind == 'Deposito') this.details[index].beneficiary_label = 'Remitente';
                if (kind == 'Ingreso') this.details[index].beneficiary_label = 'Remitente';
            },
            updateAmount: function (value, index) {
                if (index != 0) return

                let amount = parseFloat(value);
                document.getElementById('movement-amount').value = amount.toFixed(2);
            },
            setClassAndAccount: function (id, index, sub_index) {

                fetch("get-class-associative?id=" + id)
                    .then(response => response.json())
                    .then((response) => {
                        if (response.id !== null) {
                            this.$set(this.details[index].sub_details[sub_index], 'class_id', response.id)
                        }
                    })
                    .catch(error => console.log(error));

                fetch("get-account-associative?id=" + id)
                    .then(response => response.json())
                    .then((response) => {
                        if (response.id !== null) {
                            this.$set(this.details[index].sub_details[sub_index], 'chart_account_id', response.id)
                        }
                    })
                    .catch(error => console.log(error));
            }
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