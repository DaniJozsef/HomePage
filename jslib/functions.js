//Created by Dajo
//JavaScript Functions v 1.00.15
//require JQuery, min versions 1.11.0
//require lang_[hu, en, ...].js

var dateFormat = function () {
  var token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZX]|"[^"]*"|'[^']*'/g,
    timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
    timezoneClip = /[^-+\dA-Z]/g,
    pad = function (val, len) {
      val = String(val);
      len = len || 2;
      while (val.length < len) val = "0" + val;
      return val;
    };

  return function (date, mask, utc) {
    var dF = dateFormat;

    if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
      mask = date;
      date = undefined;
    }

    date = date ? new Date(date) : new Date;
    if (isNaN(date)){
      throw SyntaxError("invalid date");
    }
    mask = String(dF.masks[mask] || mask || dF.masks["default"]);

    if (mask.slice(0, 4) == "UTC:") {
      mask = mask.slice(4);
      utc = true;
    }

    var _ = utc ? "getUTC" : "get",
      d = date[_ + "Date"](),
      D = date[_ + "Day"](),
      m = date[_ + "Month"](),
      y = date[_ + "FullYear"](),
      H = date[_ + "Hours"](),
      M = date[_ + "Minutes"](),
      s = date[_ + "Seconds"](),
      L = date[_ + "Milliseconds"](),
      o = utc ? 0 : date.getTimezoneOffset(),
      X = LANG_NAMEDAYARRAY(y, m+1, d),
      flags = {
        d:    d,
        dd:   pad(d),
        ddd:  LANG_DATEFORMAT.LANG_DAYNAMES[D],
        dddd: LANG_DATEFORMAT.LANG_DAYNAMES[D + 7],
        m:    m + 1,
        mm:   pad(m + 1),
        mmm:  LANG_DATEFORMAT.LANG_MONTHNAMES[m],
        mmmm: LANG_DATEFORMAT.LANG_MONTHNAMES[m + 12],
        yy:   String(y).slice(2),
        yyyy: y,
        h:    H % 12 || 12,
        hh:   pad(H % 12 || 12),
        H:    H,
        HH:   pad(H),
        M:    M,
        MM:   pad(M),
        s:    s,
        ss:   pad(s),
        l:    pad(L, 3),
        L:    pad(L > 99 ? Math.round(L / 10) : L),
        t:    H < 12 ? LANG_AMPM.LANG_AM[0] : LANG_AMPM.LANG_PM[0],
        tt:   H < 12 ? LANG_AMPM.LANG_AM[1] : LANG_AMPM.LANG_PM[1],
        T:    H < 12 ? LANG_AMPM.LANG_AM[2] : LANG_AMPM.LANG_PM[2],
        TT:   H < 12 ? LANG_AMPM.LANG_AM[3] : LANG_AMPM.LANG_PM[3],
        Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
        o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
        S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10],
        X:    X,
      };

    return mask.replace(token, function ($0) {
      return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
    });
  };
}();

dateFormat.masks = {
  "default":      "ddd mmm dd yyyy HH:MM:ss",
  shortDate:      "m/d/yy",
  mediumDate:     "mmm d, yyyy",
  longDate:       "mmmm d, yyyy",
  fullDate:       "dddd, mmmm d, yyyy",
  shortTime:      "h:MM TT",
  mediumTime:     "h:MM:ss TT",
  longTime:       "h:MM:ss TT Z",
  isoDate:        "yyyy-mm-dd",
  isoTime:        "HH:MM:ss",
  isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
  isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'",
  dateTime:       "yyyy.mm.dd - HH:MM",
  date:           "yyyy. mmmm dd. dddd",
  time:           "HH:MM TT",
  day:            "dddd",
  yearMonthDay:   "yyyy.mm.dd",
  timeZone:       "Z",
  nameDay:        "X",
};

var initArray = function() {
  this.length = initArray.arguments.length
  for (var i = 0; i < this.length; i++)
  this[i+1] = initArray.arguments[i]
}

