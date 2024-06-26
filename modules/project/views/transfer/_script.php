<script>

    Vue.component('treeselect', VueTreeselect.Treeselect);

    var movement = new Vue({
        el: '#details',
        data: {
            details: [{
                date: null,
                benefiaciary: null,
                concept: null,
                kind: null,
                sub_details: [
                    {
                        activity: null,
                        class: null,
                        account: null,
                        amount: null
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
            options: []
        },
        methods: {
            addDetail: function (event) {
                event.preventDefault();
                this.details.push({
                    date: null,
                    benefiaciary: '',
                    concept: '',
                    kind: '',
                    sub_details: [
                        {
                            activity: null,
                            class: null,
                            account: null,
                            amount: null
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
                    amount: ''
                })
            },
            deleteSubItem: function (indexSubDetail, index) {
                event.preventDefault();
                this.details[index].sub_details.splice(indexSubDetail, 1);
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
            sumAmount: function (activities) {
                return activities.reduce((sum, activity) => {
                    return sum + parseFloat(activity.amount)
                }, 0)
            }
        },
        created() {
            this.getClassOptions();
            this.getAccountOptions();
            this.getActivityOptions();
        }
    });
</script>