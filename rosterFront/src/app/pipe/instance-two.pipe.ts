import { Pipe, PipeTransform } from '@angular/core';
import {Loot} from "../class/loot";

@Pipe({
  name: 'instanceTwo'
})
export class InstanceTwoPipe implements PipeTransform {
  transform(value: any, args?: any): any {
    if (value) {
      return value.filter( (loot: Loot) => {
        return loot.instance_value == 2;
      });
    }
    return value;
  }
}
