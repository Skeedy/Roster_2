import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NewPlayerFormComponent } from './new-player-form.component';

describe('NewPlayerFormComponent', () => {
  let component: NewPlayerFormComponent;
  let fixture: ComponentFixture<NewPlayerFormComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NewPlayerFormComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NewPlayerFormComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
