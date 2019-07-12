<?php

namespace App\Entity;

class BugReport extends Entity
{
   private $id;
   private $report_type;
   private $email;
   private $link;
   private $message;
   private $created_at;


   public function getId(): int
   {
      return $this->id;
   }


   public function setReportType(string $reportType)
   {
      $this->report_type = $reportType;

      return $this;
   }

   public function getReportType(): string
   {
      return $this->report_type;
   }

   public function getEmail(): string
   {
      return $this->email;
   }

   public function setEmail(string $email)
   {
      $this->email = $email;

      return $this;
   }

   public function getLink(): ?string
   {
      return $this->link;
   }

   public function setLink(?string $link)
   {
      $this->link = $link;

      return $this;
   }

   public function getMessage(): string
   {
      return $this->message;
   }

   public function setMessage(string $message)
   {
      $this->message = $message;

      return $this;
   }

   public function getCreated_at()
   {
      return $this->created_at;
   }

   public function toArray(): array
   {
      return [
         'report_type' => $this->getReportType(),
         'email' => $this->getEmail(),
         'message' => $this->getMessage(),
         'link' => $this->getLink(),
         'created_at' => date('Y-m-d H:i:s'),
      ];
   }
}
