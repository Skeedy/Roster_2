import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CurrentStuffComponent } from './current-stuff.component';

describe('CurrentStuffComponent', () => {
  let component: CurrentStuffComponent;
  let fixture: ComponentFixture<CurrentStuffComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CurrentStuffComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CurrentStuffComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
