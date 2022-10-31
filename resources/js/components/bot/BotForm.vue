<template>
    <div>
        <form class="" @submit.prevent="submitForm">
            <div class="row">
                <div class="text-center col-sm-12">
                    <h4>Bot Configurations
                        <span class="text-right float-right">
                            <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Save</button>
                            <button type="button" class="btn btn-secondary" @click="goBack"><i class="fas fa-arrow-left"></i> Go Back</button>
                        </span>
                    </h4>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label" for="formBasicTitle">Title</label>
                                    <div>
                                        <input placeholder="Title" name="title" type="text" id="formBasicTitle" class="form-control" v-model="form.title" :class="formErrors.title !== '' ? 'is-invalid':''"/>
                                        <p class="text-danger"><small>{{ formErrors.title }}</small></p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">Exchange</label>
                                    <select v-model="form.user_exchange_id" id="formGridState" class="form-control" :class="formErrors.user_exchange_id !== '' ? 'is-invalid':''" @change="userBalanceCheck" :disabled="this.form.id !== null ? true:false">
                                        <option v-for="(value,name,i) in JSON.parse(userExchanges)" :value="name" :key="i">{{ value }}</option>
                                    </select>
                                    <p class="text-danger"><small>{{ formErrors.user_exchange_id }}</small></p>
                                </div>
                                <div class="form-group col"><label class="form-label">Coin</label>
                                    <select v-model="form.symbol_id" id="formGridState" class="form-control" :class="formErrors.symbol_id !== '' ? 'is-invalid':''" @change="userBalanceCheck" :disabled="this.form.id !== null ? true:false">
                                        <option v-for="(value,name,i) in JSON.parse(symbols)" :value="name" :key="i">{{ value }}</option>
                                    </select>
                                    <p class="text-danger"><small>{{ formErrors.symbol_id }}</small></p>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col"><label class="form-label">Bot Option</label>
                                    <select v-model="form.is_cycle" id="formGridState" class="form-control">
                                        <option value="1">Cycle</option>
                                        <option value="0">Single</option>
                                    </select>
                                </div>
                                <div class="form-group col"><label class="form-label">Status</label>
                                    <select v-model="form.status" id="formGridState" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">In-Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col"><label class="form-label" for="formBasicEmail">Balance</label>
                                    <input placeholder="Balance" v-model="form.balance" type="number" id="formBasicEmail" class="form-control" :class="formErrors.balance !== '' ? 'is-invalid':''">
                                    <small class="form-text">Exchange Balance <b>{{ userBalance }}</b> - Bot Reserved <b>{{ botReservedBalance }} = {{ userBalance - botReservedBalance }}</b></small>
                                    <p class="text-danger"><small>{{ formErrors.balance }}</small></p>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label" for="formBasicEmail">Initial Order</label>
                                    <input placeholder="Initial Order" v-model="form.init_amount" type="number" class="form-control" value="20" :class="formErrors.init_amount !== '' ? 'is-invalid':''"/>
                                    <div class="form-check">
                                        <input v-model="form.init_immediate" @click="form.init_immediate = !form.init_immediate" type="checkbox" class="form-check-input" checked="">
                                        <label title="" for="formBasicEmail" class="form-check-label">Initiate immediately</label>
                                    </div>
                                </div>
                                <div v-if="!form.init_immediate" class="form-group col">
                                    <label class="form-label">Price after x %</label>
                                    <input placeholder="Initiate X percentage" max="0.00" step="0.01" min="-100" v-model="form.init_buy_at" type="number" class="percentage-input form-control">
                                </div>
                                <div v-if="!form.init_immediate" class="form-group col">
                                    <label class="form-label">Pullback</label>
                                    <input placeholder="Pullback" v-model="form.init_pullback" type="number" max="100" step="0.01" min="0.00" class="percentage-input form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Take Profit (Average) <a href="/bot/61603ee21bf37567f13b6aee/settings"><i class="feather icon-alert-octagon"></i></a></h5>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">Take Profit</label>
                                    <input placeholder="%" v-model="form.take_profit_average_percentage" min="0.01" max="100" step="0.01" type="number" class="percentage-input form-control" :class="formErrors.take_profit_average_percentage !== '' ? 'is-invalid':''"/>
                                    <p class="text-danger"><small>{{ formErrors.take_profit_average_percentage }}</small></p>
                                </div>
                                <div class="form-group col">
                                    <label class="form-label">Profit Re-tracement</label>
                                    <input placeholder="%" max="0.00" step="0.01" min="-100" v-model="form.take_profit_average_retracement" type="number" class="percentage-input form-control" :class="formErrors.take_profit_average_retracement !== '' ? 'is-invalid':''"/>
                                    <p class="text-danger"><small>{{ formErrors.take_profit_average_retracement }}</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title">Take Profit (Independent) <a href="#"><i class="fas fa-info"></i></a>
                        </h5></div>
                        <div class="take-profit__average card-body">
                            <div class="form-row">
                                <div class="form-group col"><label class="form-label">After X Cover</label>
                                    <select v-model="form.take_profit_independent_cover" class="form-control">
                                        <option value="0">None</option>
                                        <option v-for="cover in form.covers.length" :key="cover" :value="cover">{{ cover }}</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label class="form-label">Take Profit</label>
                                    <input v-model="form.take_profit_independent_percentage" placeholder="%" type="number" min="0.01" step="0.01" max="100" class="percentage-input form-control">
                                    <p class="text-danger"><small>{{ formErrors.take_profit_independent_percentage }}</small></p>
                                </div>
                                <div class="form-group col">
                                    <label class="form-label">Profit Re-tracement</label>
                                    <input v-model="form.take_profit_independent_retracement" placeholder="%" type="number" max="0.00" step="0.01" min="-100" class="percentage-input form-control">
                                    <p class="text-danger"><small>{{ formErrors.take_profit_independent_retracement }}</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title">Covers <a href="/bot/61603ee21bf37567f13b6aee/settings"><i class="feather icon-alert-octagon"></i></a>
                        </h5></div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Cover Index</th>
                                    <th>Cover Percentage</th>
                                    <th>Buy X time</th>
                                    <th>Cover Pullback</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr :class="index < form.take_profit_independent_cover ? 'cover-average' : ''" v-for="(cover, index) in form.covers" :key="index">
                                    <td>
                                        <div class="m-0 form-group">
                                            <input v-model="form.covers[index].index" placeholder="Index" disabled="" type="text" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="m-0 form-group">
                                            <input v-model="form.covers[index].cover_percentage" min="-100" max="0" step="0.0001" placeholder="Cover Percentage" type="number" class="percentage-input form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="m-0 form-group">
                                            <input v-model="form.covers[index].buy_x_times" min="0.0001" step="0.0001" placeholder="Buy X Times" type="number" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="m-0 form-group">
                                            <input v-model="form.covers[index].cover_pullback" placeholder="Cover Pullback" type="number" min="0.01" step="0.01" max="100" class="percentage-input form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="m-0 form-group">
                                            <button @click="removeCover(index)" type="button" class="mb-0 btn btn-outline-danger"><i class="fas fa-minus mx-1"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <button type="button" class="mb-0 btn btn-outline-success" @click="addMoreCover"><i class="fas fa-plus mx-1"></i> Add more cover</button>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="text-right col-sm-12">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Save</button>
                    <button type="button" class="btn btn-secondary" @click="goBack"><i class="fas fa-arrow-left"></i> Go Back</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
//import { ValidationProvider } from 'vee-validate';
const formErrorsInit = {
    title: '',
    balance: '',
    init_amount: '',
    take_profit_average_percentage: '',
    take_profit_average_retracement: '',
    take_profit_independent_cover: '',
    take_profit_independent_percentage: '',
    take_profit_independent_retracement: '',
    user_exchange_id: '',
    symbol_id: '',
};
    export default {
        /*components: {
            //ValidationProvider,
        },*/
        props: ['userExchanges','symbols','userId', 'bot','reservedBalance'],
        data() {
            return {
                form: {
                    id: null,
                    title: "",
                    balance: 1000,
                    is_cycle: 1,
                    init_immediate: 1,
                    init_amount: 20,
                    init_buy_at: -1.5,
                    init_pullback: 0.5,
                    take_profit_average_percentage: 1.5,
                    take_profit_average_retracement: -0.5,
                    take_profit_independent_cover: 3,
                    take_profit_independent_percentage: 1,
                    take_profit_independent_retracement: -0.5,
                    status: 1,
                    is_simulated: 0,
                    user_id: this.userId,
                    user_exchange_id: '',
                    symbol_id: '',
                    covers: [
                        {
                            index: 1,
                            cover_percentage: -2,
                            cover_pullback: 0.5,
                            buy_x_times: 2
                        },
                        {
                            index: 2,
                            cover_percentage: -4,
                            cover_pullback: 0.5,
                            buy_x_times: 4
                        },
                        {
                            index: 3,
                            cover_percentage: -6,
                            cover_pullback: 0.5,
                            buy_x_times: 8
                        },
                        {
                            index: 4,
                            cover_percentage: -8,
                            cover_pullback: 0.5,
                            buy_x_times: 16
                        },
                        {
                            index: 5,
                            cover_percentage: -10,
                            cover_pullback: 0.5,
                            buy_x_times: 32
                        },
                        {
                            index: 6,
                            cover_percentage: -12,
                            cover_pullback: 0.5,
                            buy_x_times: 64
                        }
                    ]
                },
                userBalance: 0,
                formErrors: formErrorsInit,
                botReservedBalance: 0
            }
        },
        mounted() {
            if(this.bot !== 'NEW') {
                this.form = JSON.parse(this.bot);
                this.form.take_profit_average_retracement = this.form.take_profit_average_retracement.toFixed(2)
                this.form.take_profit_independent_retracement = this.form.take_profit_independent_retracement.toFixed(2)
                this.userBalanceCheck()
                //console.info(this.form);
            }
        },
        methods: {
            goBack() {
                if( this.form.id === null ) {
                    window.location.href = this.$isAdmin ? '/admin/bots' : '/bots';
                } else {
                    window.location.href = this.$isAdmin ?`/admin/bots/${this.form.id}`:`/bots/${this.form.id}`;
                }
            },
            submitForm() {
                if(!this.$isAdmin) {
                    if(this.form.balance > this.userBalance + this.botReservedBalance) {
                        if(!confirm("Balance exceed to the limit, Are you sure you want to continue?")) {
                            this.formErrors['balance'] = "Balance exceed to the limit";
                        }
                    }
                    this.formErrors = formErrorsInit;
                    if( this.form.id === null ) {
                        axios.post(`/api/v1/bots/create`, this.form)
                            .then( response => {
                                if(response.data.success) {
                                    window.location.href = '/bots';
                                } else {
                                    if(response.data.data === 203) {
                                        alert(response.data.message);
                                    }
                                    for(const [key,value] of Object.entries(response.data.data)) {
                                        this.formErrors[key] = value[0];
                                    }
                                }
                            })
                            .catch( error => {
                                console.log( error );
                                alert(error.message);
                            });
                    } else {
                        axios.put(`/api/v1/bots/${this.form.id}`, this.form)
                            .then( response => {
                                if(response.data.success) {
                                    window.location.href = '/bots';
                                } else {
                                    for(const [key,value] of Object.entries(response.data.data)) {
                                        this.formErrors[key] = value[0];
                                    }
                                }
                            })
                            .catch( error => {
                                console.log( error )
                            });
                    }
                } else {
                    alert("You're not allowed to perform this action")
                }
            },
            addMoreCover() {
                this.form.covers.push({
                    index: this.form.covers.length + 1,
                    cover_percentage: -2,
                    cover_pullback: 0.5,
                    buy_x_times: 2
                });
            },
            removeCover(coverIndex) {
                this.form.covers.splice(coverIndex, 1)
                let covers = [];
                this.form.covers.map( (cover, index) => {
                    cover.index = index + 1
                    covers.push(cover);
                })
                this.form.covers = covers;
            },
            userBalanceCheck() {
                if(this.form.user_exchange_id !== '' && this.form.symbol_id) {
                    axios.get(`/api/v1/user/balance/${this.form.user_exchange_id}/${this.form.symbol_id}`).then( response => {
                        this.userBalance = parseFloat(response.data.user_balance).toFixed(2);
                        let symbols = JSON.parse(this.symbols)
                        let symbol = symbols[this.form.symbol_id].split("/")[1];
                        let reserved = JSON.parse(this.reservedBalance);
                        if(typeof reserved[symbol] !== "undefined") {
                            this.botReservedBalance = reserved[symbol];
                        }
                        console.info(this.botReservedBalance);
                    }).catch( error => {
                        console.error( error );
                    })
                }
            }
        }
    }
</script>
