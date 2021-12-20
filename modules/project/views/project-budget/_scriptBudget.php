<script>
    Vue.component('treeselect', VueTreeselect.Treeselect);
    Vue.use('v-money', {precision: 4});

    var assign = new Vue({
        el: '#assign',
        money: {
            decimal: '.',
            thousands: ',',
            prefix: 'Lps ',
            precision: 2,
            masked: false
        },
        data: {
            categories: [],
            period: null,
            budget_options: [],
            period_options: []
        },
        methods: {
            initSettings: function () {
                this.budget_options.push({
                    id: document.getElementById('budget_id').value,
                    label: document.getElementById('budget_name').value
                });
            },
            async getData() {
                try {
                    let response = await fetch("get-all?id=" + this.budget_options[0].id + "&period_id=" + this.period);
                    this.categories = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getPeriods() {
                try {
                    let response = await fetch("get-periods-by-project?id=" + this.budget_options[0].id);
                    this.period_options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            sumAmount: function (activities) {
                return activities.reduce((sum, activity) => {
                    return sum + parseFloat(activity.amount)
                }, 0)
            },
            sumExecute: function (activities) {
                return activities.reduce((sum, activity) => {
                    return sum + parseFloat(activity.used)
                }, 0)
            },
            sumAviable: function (activities) {
                return activities.reduce((sum, activity) => {
                    return sum + parseFloat(activity.aviable)
                }, 0)
            }
        },
        created() {
            this.initSettings();
            this.getPeriods();
        }
    });
</script>