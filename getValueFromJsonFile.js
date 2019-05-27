'use strict';

const fs = require('fs');
const args = process.argv;

let rawdata = fs.readFileSync(args[2]);
let data = JSON.parse(rawdata);  
console.log(data.extra.component.id);
