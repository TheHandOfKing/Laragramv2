import moment from "moment"

export const toHuman = (date) => {
  if (typeof date == "undefined") return;
  return moment(date, "YYYYMMDD").fromNow();
}