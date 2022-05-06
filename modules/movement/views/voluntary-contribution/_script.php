<script>
    Vue.component('treeselect', VueTreeselect.Treeselect);
    Vue.use('v-money', {precision: 4});

    var movement = new Vue({
        el: '#voluntary-contribution-detail',
        data: {
            errors: false,
            money: {
                decimal: '.',
                thousands: ',',
                precision: 2,
                masked: false
            },
            details: [
                {
                    id: null,
                    benefiaciary: null,
                    memo: 'Aporte Voluntario',
                    amount: 0
                }
            ],
            beneficiaries_options: [],
        },
        methods: {
            store() {
                let voluntary_contribution_id = document.getElementById('voluntary_contribution_id').value;
                this.errors = null;
                $.ajax({
                    url: 'store?id=' + voluntary_contribution_id,
                    method: 'POST',
                    data: $("#w0").serializeArray()
                }).done(data => {
                    var response = JSON.parse(data)
                   window.location.href = "view?id=" + response.id;
                }).fail(data => {
                    this.errors = $.parseJSON(data.responseText)
                })
            },
            addDetail: function (event) {
                event.preventDefault();
                let last_memo = this.details.length > 0 ? this.details[this.details.length - 1].memo : '';
                this.details.push(
                    {
                        id: null,
                        benefiaciary: null,
                        memo: last_memo,
                        amount: 0
                    }
                );
            },
            deleteDetail: function (index) {
                event.preventDefault();
                this.details.splice(index, 1);
            },
            async getBeneficiaries() {
                try {
                    let response = await fetch("get-all-beneficiaries");
                    this.beneficiaries_options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getValues() {
                let voluntary_contribution_id = document.getElementById('voluntary_contribution_id').value;

                if (voluntary_contribution_id != -1) {
                    try {
                        let response = await fetch("get-details?id=" + voluntary_contribution_id);
                        this.details = await response.json();
                    } catch (error) {
                        console.log(error);
                    }
                }
            }
        },
        created() {
            this.getBeneficiaries();
            this.getValues();
        },
    })
</script>