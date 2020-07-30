import { Pipe, PipeTransform } from '@angular/core';
import {Item} from "../class/item";

@Pipe({
  name: 'magicWeapon'
})
export class MagicWeaponPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    if (value) {
      return value.filter( (item: Item) => {
        for(let i=0; i<item.jobs.length; i++) {
          return item.jobs[i].subrole === 'magic'
        }
      });
    }
    return value;
  }

}
