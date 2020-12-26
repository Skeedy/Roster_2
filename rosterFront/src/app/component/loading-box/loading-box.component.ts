import { Component, OnInit } from '@angular/core';
import {animate, style, transition, trigger} from "@angular/animations";
import {LoadingService} from "../../service/loading.service";

@Component({
  selector: 'app-loading-box',
  templateUrl: './loading-box.component.html',
  styleUrls: ['./loading-box.component.scss'],
  animations: [
    trigger('successShow', [
      transition('void => *', [ // using status here for transition
        style({ opacity: 0 }),
        animate(400, style({ opacity: 1 }))
      ]),
      transition('* => void', [
        animate(400, style({ opacity: 0 }))
      ])
    ])
  ]
})
export class LoadingBoxComponent implements OnInit {

  constructor(public loadingServ: LoadingService) { }

  ngOnInit(): void {
  }

}
