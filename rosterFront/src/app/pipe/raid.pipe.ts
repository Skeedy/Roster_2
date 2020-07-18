import { Pipe, PipeTransform } from '@angular/core';
import {Loot} from "../class/loot";

@Pipe({
  name: 'raid'
})
export class RaidPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    if (value) {
      return value.filter( (loot : Loot) => {
        return loot.instance.id === 1;
      });
    }
    return value;
  }

}
