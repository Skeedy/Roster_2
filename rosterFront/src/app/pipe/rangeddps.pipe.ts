import { Pipe, PipeTransform } from '@angular/core';
import {Job} from "../class/job";

@Pipe({
  name: 'rangeddps'
})
export class RangeddpsPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    if (value) {
      return value.filter( (jobs: Job) => {
        return jobs.subrole === 'ranged';
      });
    }
    return value;
  }

}
