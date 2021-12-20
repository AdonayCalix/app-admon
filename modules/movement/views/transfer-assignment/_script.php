<script>
    Vue.component('treeselect', VueTreeselect.Treeselect);
    Vue.use('v-money', {precision: 4})

    var transfer_assignment = new Vue({
        el: '#tansfer_assignment',
        data: {
            errors: null,
            assign_detail: [
                {
                    id: null,
                    beneficiary_id: null,
                    amount: 0,
                    reason: null,
                    position: null
                }
            ],
            beneficiaries_options: null,
            position_options: null,
            transfer_options: null,
            transfer_id: null
        },
        methods: {
            store() {
                this.errors = null;
                $.ajax({
                    url: 'store',
                    method: 'POST',
                    data: $("#w0").serializeArray()
                }).done(data => {
                    document.getElementById('flash').innerHTML = `<div class="alert-success alert alert-dismissible" role="alert">
                    Se almaceno correctamente el movimiento
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
                </div>`;
                    this.assign_detail = [];
                    this.transfer_id = null;
                    document.getElementById('transfer_id').value = null;
                    document.getElementById('isNewRecord').value = 'ok';
                    document.documentElement.scrollTop = 0;
                }).fail(data => {
                    this.errors = $.parseJSON(data.responseText)
                })
            },
            addAssignDetail: function (event) {
                event.preventDefault();
                this.assign_detail.push({
                    id: null,
                    beneficiary_id: null,
                    amount: 0,
                    reason: null,
                    position: null
                });
            },
            deleteAssignDetail: function (index) {
                event.preventDefault();
                this.assign_detail.splice(index, 1);
            },
            async getValues() {
                let movement_id = document.getElementById('transfer_id').value;
                this.transfer_id = movement_id;
                console.log(movement_id);
                if (movement_id !== -1) {
                    try {
                        let response = await fetch("get-transfer-assignments?transfer_id=" + movement_id);
                        this.assign_detail = await response.json();
                    } catch (error) {
                        console.log(error);
                    }
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
            async getPositions() {
                try {
                    let response = await fetch("get-all-positions");
                    this.position_options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getTransfers() {
                try {
                    let response = await fetch("get-all-transfers");
                    this.transfer_options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            sumAmount: function (detail) {
                return detail.reduce((sum, detail) => {
                    return sum + parseFloat(detail.amount)
                }, 0)
            },
        },
        created() {
            this.getValues();
            this.getBeneficiaries();
            this.getPositions();
            this.getTransfers();
        }
    });

    $(':input').attr("autocomplete", "off");

</script>
