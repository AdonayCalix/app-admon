<script>
    Vue.component('treeselect', VueTreeselect.Treeselect);

    var assign = new Vue({
        el: '#assign',
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
            async getPeriods() {
                try {
                    let response = await fetch("get-all?id=" + this.budget_options[0].id);
                    this.categories = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getData() {
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
            this.getData();
        }
    });
</script>