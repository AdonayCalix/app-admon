<script>
    Vue.component('treeselect', VueTreeselect.Treeselect);
    Vue.use(DatePicker);
    Vue.use('v-money', {precision: 4})

    var expense_details = new Vue({
        el: '#expense_details',
        data: {
            errors: false,
            money: {
                decimal: '.',
                thousands: ',',
                precision: 2,
                masked: false
            },
            food_expenses: [
                {
                    id: null,
                    date: new Date(),
                    place_id: null,
                    breakfast: 0,
                    lunch: 0,
                    dinner: 0
                }
            ],
            other_expenses: [
                {
                    id: null,
                    expense_id: null,
                    amount: 0
                }
            ],
            places_options: [],
            advance_details: [],
        },
        methods: {
            storeNewExpense() {
                $.ajax({
                    url: 'store-new-expense',
                    method: 'POST',
                    data: {name: document.getElementById('new_expense').value}
                }).done(data => {
                    document.getElementById('exampleModal').click();
                    document.getElementById('new_expense').value = '';
                    this.getAdvanceDetailOptions();
                }).fail(data => {
                    this.errors = $.parseJSON(data.responseText)
                })
            },
            storeNewPlace() {
                $.ajax({
                    url: 'store-new-place',
                    method: 'POST',
                    data: {name: document.getElementById('new-place').value}
                }).done(data => {
                    document.getElementById('newPlace').click();
                    document.getElementById('new-place').value = '';
                    this.getAllPlaces();
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
                    var json = JSON.parse(data);
                    window.location.href = "other-create?id=" + json.id;
                }).fail(data => {
                    this.errors = $.parseJSON(data.responseText);
                    console.log(this.errors);
                })
            },
            deleteFoodExpense: function (index) {
                event.preventDefault();
                this.food_expenses.splice(index, 1);
            },
            addNewFoodExpense: function () {
                event.preventDefault();
                this.food_expenses.push({
                    id: null,
                    date: new Date(),
                    place_id: null,
                    breakfast: 0,
                    lunch: 0,
                    dinner: 0
                })
            },
            deleteOtherExpense: function (index) {
                event.preventDefault();
                this.other_expenses.splice(index, 1);
            },
            addNewOtherExpense: function () {
                event.preventDefault();
                this.other_expenses.push({
                    id: null,
                    expense_id: null,
                    amount: 0
                })
            },
            async getAdvanceDetailOptions() {
                try {
                    let response = await fetch("get-advance-detail");
                    this.advance_details = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getAllPlaces() {
                try {
                    let response = await fetch("get-all-places");
                    this.places_options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getValues() {
                let expense_request_id = document.getElementById('expanse_request_id').value;
                console.log(expense_request_id);

                if (expense_request_id != -1) {
                    try {
                        let response = await fetch("get-all-food-expense?id=" + expense_request_id);
                        this.food_expenses = await response.json();
                        await this.food_expenses.map((detail) => {
                            console.log(detail.date);
                            let arrayDate = detail.date.split("-");
                            detail.date = new Date(arrayDate[0], (arrayDate[1] - 1), arrayDate[2]);
                        });
                    } catch (error) {
                        console.log(error);
                    }

                    try {
                        let response = await fetch("get-all-advance-detail?id=" + expense_request_id);
                        this.other_expenses = await response.json();
                    } catch (error) {
                        console.log(error);
                    }
                } else {
                    try {
                        let response = await fetch("get-all-advance-detail-previous");
                        this.other_expenses = await response.json();
                    } catch (error) {
                        console.log(error);
                    }
                }
            }
        },
        created() {
            this.getValues();
            this.getAdvanceDetailOptions();
            this.getAllPlaces();
        }
    })
</script>