<template>
  <div class="row justify-content-center mx-0">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header">Calendar</div>

        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label>Event</label>
                    <input class="form-control" v-model="form.name" />
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label>From</label>
                    <input type="date" class="form-control" v-model="form.from" />
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label>To</label>
                    <input type="date" class="form-control" v-model="form.to" />
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      id="mon"
                      v-model="form.daysOfWeek"
                      :value="1"
                    />
                    <label class="form-check-label">Mon</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      id="tue"
                      v-model="form.daysOfWeek"
                      :value="2"
                    />
                    <label class="form-check-label">Tue</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      id="wed"
                      v-model="form.daysOfWeek"
                      :value="3"
                    />
                    <label class="form-check-label">Wed</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      id="thu"
                      v-model="form.daysOfWeek"
                      :value="4"
                    />
                    <label class="form-check-label">Thu</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      id="fri"
                      v-model="form.daysOfWeek"
                      :value="5"
                    />
                    <label class="form-check-label">Fri</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      id="sat"
                      v-model="form.daysOfWeek"
                      :value="6"
                    />
                    <label class="form-check-label">Sat</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      id="sun"
                      v-model="form.daysOfWeek"
                      :value="7"
                    />
                    <label class="form-check-label">Sun</label>
                  </div>
                </div>

                <div class="col-12">
                  <button class="btn btn-primary my-1" @click="save()">Save</button>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <table class="table">
                <template v-for="(date, index) in dates">
                  <tr :key="'head' + index" v-if="index == 0 || date.month != dates[index-1].month">
                    <th colspan="2"><h3>{{ date.month }} {{ date.year }}</h3></th>
                  </tr>

                  <tr :class="{'active': date.event}" :key="index">
                    <td style="width: 150px;">{{ date.day }} {{ date.dayOfWeek }}</td>
                    <td>{{ date.event ? date.event.name : '' }}</td>
                  </tr>
                </template>
              </table>

              <!-- <pre>{{dates}}</pre> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment-timezone";
import axios from "axios";
import swal from "sweetalert2";

export default {
  data: () => {
    return {
      dates: [],
      event: null,
      form: {
        name: null,
        from: null,
        to: null,
        daysOfWeek: []
      }
    };
  },
  mounted() {
    this.enumerateDaysBetweenDates();
  },
  methods: {
    save() {
      axios
        .post("/api/event", this.form)
        .then(response => {
          this.event = response.data;
          this.enumerateDaysBetweenDates();

          swal.fire({
            title: "Event Successfully Saved",
            icon: "success",
            timer: 1500
          });
        })
        .catch(err => {
          console.log(err);
          swal.fire({
            title: "Unsuccessful",
            icon: "error"
          });
        });
    },

    enumerateDaysBetweenDates: function() {
      var dates = [];

      var currDate = moment()
        .startOf("month")
        .startOf("day");

      var lastDate = moment()
        .endOf("month")
        .startOf("day");

      if(this.event) {
        currDate = moment(this.event.from)
          .startOf("month")
          .startOf("day");

        lastDate = moment(this.event.to)
          .endOf("month")
          .startOf("day");
      }

      do {
        var date = {
          dayOfWeek: currDate.clone().format("ddd"),
          month: currDate.clone().format("MMMM"),
          year: currDate.clone().format("YYYY"),
          day: currDate.clone().format("D"),
          event: null
        };

        if (this.event) {
          if (_.includes(JSON.parse(this.event.days_of_week), currDate.isoWeekday()) 
              && currDate >= moment(this.event.from) 
              && currDate <= moment(this.event.to)) {
            date.event = this.event;
          }
        }

        dates.push(date);
      } while (currDate.add(1, "days").diff(lastDate) <= 0);

      this.dates = dates;
    }
  }
};
</script>


<style scoped>
tr.active {
  background-color: #80ED9A;
}

th {
  font-weight: bold;
}
</style>