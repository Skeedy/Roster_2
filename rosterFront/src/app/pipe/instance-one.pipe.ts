import { Pipe, PipeTransform } from '@angular/core';
import {Loot} from "../class/loot";

@Pipe({
  name: 'instanceOne'
})
export class InstanceOnePipe implements PipeTransform {
  transform(value: any, args?: any): any {
    if (value) {
      return value.filter( (loot: Loot) => {
        return loot.instance_value == 1;
      });
    }
    return value;
  }
}
