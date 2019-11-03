export let parseJson = function(str) {
  try {
    let o = JSON.parse(str);

    if (o && typeof o === "object") {
      return o;
    }
  }
  catch (e) { }

  return false;
};

export let isJson = function(str) {
  try {
    JSON.parse(str);
  } catch (e) {
    return false;
  }
  return true;
};

export let isObject = function(val) {
  return typeof val === 'object';
};

export let convertUtc = function(date) {
    let newDate = new Date(date);
    return Date.UTC(
        newDate.getFullYear(),
        newDate.getMonth(),
        newDate.getDate(),
        newDate.getHours(),
        newDate.getMinutes(),
        newDate.getSeconds(),
        newDate.getMilliseconds()
    );
};

export let getPageBoxAction = function(title, icon = '', bind = {}, on = {}) {
  return {
      title: title,
      icon: icon,
      bind: bind,
      on: on
  };
};

/*
export let formatDate = function(date) {
    if (!date) return null;

    const [year, month, day] = date.split('-');
    return `${year}-${month}-${day}`
};

export let parseDate = function(date) {
    if (!date) return null;

    const [year, month, day] = date.split('-');
    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
};*/
