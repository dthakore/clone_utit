<template>
    <div data-testid="wrapper" class="_loading_overlay_wrapper css-79elbk">
        <bot-stats :bot="botInfo" />
        <div class="row" v-for="(session,j) in sessions" :key="session.id">
            <div class="col">
                <div class="card card-outline direct-chat direct-chat-success shadow-sm" :class="session.status === 'OPEN' ? 'card-success':'card-secondary'">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">Session <small><span class="text-gray">#{{session.id}}</span> {{ datetimeFormat(session.created_at) }} {{ session.status !== 'OPEN' ? `- ${datetimeFormat(session.updated_at)}`:'' }}</small> &nbsp;</h3>
                            <session-stats :take_profit_button="session.status === 'OPEN'" :trades="session.trades" :session="session" :bot="botInfo" @profitLoss="profitLoss"/>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Side</th>
                                    <th class="text-right">Price</th>
                                    <th class="text-right">Quantity</th>
                                    <th class="text-right">Amount</th>
                                    <th class="text-right">Profit/Loss</th>
                                    <th>Info</th>
                                    <th class="text-center">Closed At</th>
                                    <th class="text-center">Created At</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="session.trades.length > 0" v-for="(trade,i) in session.trades" :key="trade.id" :class="`trade-status-${trade.status} ${ trade.status && trade.closed_at === null ? 'trade-closed':'' }`">
                                    <th scope="row">{{ trade.id }}</th>
                                    <td>{{ trade.side }}</td>
                                    <td class="text-right">{{ trade.status ? trade.executed_price.toFixed(2) : trade.requested_price.toFixed(2) }}</td>
                                    <td class="text-right">{{ trade.status ? trade.executed_quantity.toFixed(8) : trade.requested_quantity.toFixed(8) }}</td>
                                    <td class="text-right">{{ trade.status ? trade.executed_amount.toFixed(8) : trade.requested_amount.toFixed(8) }}</td>
                                    <td class="text-right">{{ trade.status ? trade.profit_loss.toFixed(8) : 0 }}</td>
                                    <td>{{ trade.status ? tradeTypes(trade) : trade.failure_reason }}</td>
                                    <td class="text-center">{{ datetimeFormat(trade.closed_at) }}</td>
                                    <td class="text-center">
                                        {{ datetimeFormat(trade.created_at) }}
                                    </td>
                                </tr>
                                <tr v-if="session.trades.length > 0">
                                    <td colspan="5" class="text-right"><b>Total Profit / Loss</b></td>
                                    <td class="text-right"><b :ref="`profit-loss-${session.id}`"></b></td>
                                    <td colspan="3"></td>
                                </tr>
                                <tr v-if="session.trades.length === 0">
                                    <td colspan="8" class="text-center"> No trades </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bottom-100">
            <div class="text-center col-sm-12">
                <button v-if="loadMore" type="button" class="btn btn-secondary" @click="fetchTrades">Load More</button>
                <span v-if="loadMore === 0">No more data</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BotTrades",
    props: ['bot'],
    data() {
        return {
            botInfo: JSON.parse(this.bot),
            sessions: [],
            loadMore: true,
            profitLossCol:[]
        }
    },
    mounted() {
        this.fetchTrades();
    },
    methods: {
        fetchTrades() {
            axios.get(`/api/v1/bot/${this.botInfo.id}/trades/${this.sessions.length}`).then( response => {
                this.loadMore = response.data.sessions.length
                this.sessions = [...new Set([...this.sessions, ...response.data.sessions])];
            }).catch( error => {
                console.log(error);
            })
        },
        profitLoss(pl) {
            this.$refs[`profit-loss-${pl.sessionId}`][0].innerText = pl.pl.toFixed(8);
        }
    }
}
</script>

<style scoped>
    .trade-status-0 {
        background-color: darkred;
        color: white;
    }
    .trade-status-0:hover {
        background-color: darkred;
        color: white;
    }

    .trade-closed {
        color: darkgreen;
    }
</style>
