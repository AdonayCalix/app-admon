<script>

    Vue.component('treeselect', VueTreeselect.Treeselect);

    var movement = new Vue({
        el: '#financial-format',
        data: {
            period_id: null,
            budget_id: null,
            period_list: [],
            budget_list: [],
            project_list: [],
            project_id: null
        },
        methods: {
            download: function (event) {
                event.preventDefault();
                window.location.assign("download?project_id=" + this.project_id + "&budget_id=" + this.budget_id + "&period_id=" + this.period_id);
            },
            async getPeriods() {
                try {
                    let response = await fetch("get-periods?budget_id=" + this.budget_id);
                    this.period_list = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getBudgets() {
                try {
                    let response = await fetch("get-budgets?project_id=" + this.project_id);
                    this.budget_list = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getProject() {
                try {
                    let response = await fetch("get-projects");
                    this.project_list = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
        },
        created() {
            this.getProject()
        },
        watch: {
            project_id: function () {
                this.getBudgets();
            },
            budget_id: function () {
                this.getPeriods();
            }
        }
    });
</script>