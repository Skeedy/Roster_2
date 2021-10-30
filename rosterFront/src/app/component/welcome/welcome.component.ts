import {Component, OnInit, Output, EventEmitter, Input} from '@angular/core';
import {CookieService} from "ngx-cookie-service";

@Component({
  selector: 'app-welcome',
  templateUrl: './welcome.component.html',
  styleUrls: ['./welcome.component.scss']
})
export class WelcomeComponent implements OnInit {
  @Output() onCloseClick = new EventEmitter();

  constructor(public cookieServ: CookieService) { }

  ngOnInit(): void {
  }
  acceptCoockies(){
    this.cookieServ.set('is_first_time', 'true');
    this.cookieServ.set('SameSite', 'Lax');
  }
  deny(){
    this.onCloseClick.emit();
  }
}
