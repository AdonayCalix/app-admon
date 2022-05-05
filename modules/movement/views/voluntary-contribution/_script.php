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
                    memo: null,
                    amount: 0
                }
            ],
            beneficiaries_options: [],
        },
        methods: {
            async getBeneficiaries() {
                try {
                    let response = await fetch("get-all-beneficiaries");
                    this.beneficiaries_options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            }
        },
        created() {
            this.getBeneficiaries();
        },
    })
</script>