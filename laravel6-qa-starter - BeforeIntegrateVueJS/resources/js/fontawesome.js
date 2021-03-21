import { config, library, dom } from '@fortawesome/fontawesome-svg-core'
config.autoReplaceSvg = 'nest'
console.log(library);
console.log(dom);
console.log(config);

import { fas } from '@fortawesome/free-solid-svg-icons'

library.add(fas)


dom.watch()