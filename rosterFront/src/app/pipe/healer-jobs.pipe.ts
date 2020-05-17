import { Pipe, PipeTransform } from '@angular/core';
import {Job} from "../class/job";

@Pipe({
  name: 'healerJobs'
})
export class HealerJobsPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    if (value) {
      return value.filter( (jobs: Job) => {
        return jobs.role === 'HEALER';
      });
    }
    return value;
  }

}
