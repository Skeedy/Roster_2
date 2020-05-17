import { Pipe, PipeTransform } from '@angular/core';
import {Job} from "../class/job";

@Pipe({
  name: 'magicdps'
})
export class MagicdpsPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    if (value) {
      return value.filter( (jobs: Job) => {
        return jobs.subrole === 'magic';
      });
    }
    return value;
  }

}
