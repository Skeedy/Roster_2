import { Component, OnInit } from '@angular/core';
import {ErrorService} from "../../service/error.service";
import {animate, style, transition, trigger} from "@angular/animations";

@Component({
  selector: 'app-error-block',
  templateUrl: './error-block.component.html',
  styleUrls: ['./error-block.component.scss'],
  animations: [
    trigger('errorShow', [
      transition('void => *', [
        style({ transform: 'scale3d(.3, .3, .3)' }),
        animate(100)
      ]),
      transition('* => void', [
        animate(100, style({ transform: 'scale3d(.0, .0, .0)' }))
      ])
    ])
  ]
})
export class ErrorBlockComponent implements OnInit {

  constructor(public errorServ: ErrorService) { }

  ngOnInit(): void {
  }

}
