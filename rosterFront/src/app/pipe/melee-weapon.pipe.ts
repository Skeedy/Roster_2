import { Pipe, PipeTransform } from '@angular/core';
import {Item} from "../class/item";
import {Job} from "../class/job";

@Pipe({
  name: 'meleeWeapon'
})
export class MeleeWeaponPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    if (value) {
      return value.filter( (item: Item) => {
        for(let i=0; i<item.jobs.length; i++) {
          return item.jobs[i].subrole === 'melee'
        }
        });
    }
    return value;
  }
}
