import { Component, OnInit } from '@angular/core';
import {SuccessService} from "../../service/success.service";
import {animate, state, style, transition, trigger} from "@angular/animations";

@Component({
  selector: 'app-success-block',
  templateUrl: './success-block.component.html',
  styleUrls: ['./success-block.component.scss'],
  animations: [
    trigger('successShow', [
      transition('void => *', [ // using status here for transition
        style({ opacity: 0 }),
        animate(1000, style({ opacity: 1 }))
      ]),
      transition('* => void', [
        animate(1000, style({ opacity: 0 }))
      ])
    ])
  ]
})
export class SuccessBlockComponent implements OnInit {

  constructor(public successServ: SuccessService) { }

  ngOnInit(): void {
  }

}
