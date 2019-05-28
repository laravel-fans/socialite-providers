'use strict';

const fs = require('fs');
const getValue = (object, path) => path.split('.').reduce((o, k) => (o || {})[k], object),
      data = { key: { subKey: 'value' } },
      theString = 'key.subKey';

const args = process.argv;
const file = args[2];
const key = args[3];

const raw = fs.readFileSync(file);
const obj = JSON.parse(raw);
console.log(getValue(obj, key));
