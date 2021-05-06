<?php

namespace Kunstmaan\MediaBundle\Validator\Constraints;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ExtensionValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate(
        $value,
        Constraint $constraint
    ): void {
        if (!$value instanceof File) {
            return;
        }

        if (!$constraint instanceof ExtensionConstraint) {
            throw new InvalidArgumentException('Constraint should be instance of ' . ExtensionConstraint::class);
        }

        $this->validateExtension(
            $value,
            $constraint
        );
    }

    private function validateExtension(
        File $file,
        ExtensionConstraint $constraint
    ): void {
        $isWhitelisted = $this->isWhitelisted(
            $file,
            $constraint
        );

        if (!$isWhitelisted) {
            $this
                ->context
                ->buildViolation('extension_is_not_allowed.label')
                ->addViolation()
            ;
        }

        $isBlacklisted = $this->isBlacklisted(
            $file,
            $constraint
        );

        if ($isBlacklisted) {
            $this
                ->context
                ->buildViolation('extension_is_not_allowed.label')
                ->addViolation()
            ;
        }
    }

    private function isWhitelisted(
        File $file,
        ExtensionConstraint $constraint
    ): bool {
        $whitelistedExtensions = $constraint->whitelistedExtensions;

        if (!count($whitelistedExtensions)) {
            return true;
        }

        return in_array(
            $file->getExtension(),
            $whitelistedExtensions,
            true
        );
    }

    private function isBlacklisted(
        File $file,
        ExtensionConstraint $constraint
    ): bool {
        $blacklistedExtensions = $constraint->blacklistedExtensions;

        if (!count($blacklistedExtensions)) {
            return false;
        }

        return in_array(
            $file->getExtension(),
            $blacklistedExtensions,
            true
        );
    }
}
