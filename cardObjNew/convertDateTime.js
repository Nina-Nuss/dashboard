//!!!!!!!!achtung: system uhrzeit muss richtig eingestellt sein!!!!!!!!!!!!!

function showData(obj, selectedDateRange) {
    // Given string
    // Split the string by ' - '    
    const [startDate, endDate] = selectedDateRange.split(' - ');
    console.log(startDate, endDate);
    createDateTimeObj(obj, startDate, endDate)
    // Further split start and end dates into separate components
    const [startDateValue, startTime] = startDate.trim().split(' ');
    const [endDateValue, endTime] = endDate.trim().split(' ');
    // Create variables
    const start_date = startDateValue; // '17-10-2024'
    const start_time = startTime;       // '00:00'
    const end_date = endDateValue;      // '25-10-2024'
    const end_time = endTime;           // '23:59'
    // Output the variables
    console.log(start_date); // '17-10-2024'
    console.log(start_time); // '00:00'
    console.log(end_date);   // '25-10-2024'
    console.log(end_time);   // '23:59'
}

function createDateTimeObj(obj, startDate, endDate) {
    moment.locale('de');
    // Example date string in German format with time
    // Parse the date and time string using Moment.js
    const startDateParse = moment(startDate, 'DD-MM-YYYY HH:mm');
    const endDateParse = moment(endDate, 'DD-MM-YYYY HH:mm');
    // Format the parsed date and time in a different format if needed
    const formattedStartDate = startDateParse.format('YYYY-MM-DD HH:mm');
    console.log('Parsed StartDateTime:', startDateParse.format());
    console.log('Formatted StartDateTime:', formattedStartDate);
    // Format the parsed date and time in a different format if needed
    const formattedEndDate = endDateParse.format('YYYY-MM-DD HH:mm');
    console.log('Parsed EndDateTime:', endDateParse.format());
    console.log('Formatted EndDateTime:', formattedEndDate);
    // Convert parsed date to JavaScript Date object
    const dateObjStart = new Date(formattedStartDate);
    const dateObjEnd = new Date(formattedEndDate);
    obj.startDateTime = dateObjStart
    obj.endDateTime = dateObjEnd
    console.log(obj.startDateTime);
    console.log(obj.endDateTime);
}



