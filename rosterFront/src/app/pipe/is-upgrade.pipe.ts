import { Pipe, PipeTransform } from '@angular/core';
import {Item} from "../class/item";

@Pipe({
  name: 'isUpgrade'
})
export class IsUpgradePipe implements PipeTransform {

  transform(value: any, args?: any): any {
    if (value) {
      return value.filter( (item: Item) => {
        return item.isUpgrade;
      });
    }
    return value;
  }
}
